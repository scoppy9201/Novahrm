<?php

namespace App\packages\Nova\document\src\Http\Controllers;

use App\packages\Nova\document\src\Models\Document;
use App\packages\Nova\document\src\Models\DocumentApproval;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
     use AuthorizesRequests;

    public function index(Request $request)
    {
        /** @var \Nova\Auth\Models\Employee $user */
        $user = $request->user();

        $documents = Document::with('category')

            // Filter theo tab
            ->when($request->tab === 'personal', fn($q) => $q->where('employee_id', $user->id))
            ->when($request->tab === 'company',  fn($q) => $q->whereNull('employee_id'))
            ->when($request->tab === 'pending',  fn($q) => $q->where('status', 'pending'))
            ->when($request->tab === 'signing',  fn($q) => $q->where('status', 'signing'))

            // Filter theo search
            ->when($request->search, fn($q) => $q->where(fn($q2) => $q2
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('file_name', 'like', '%' . $request->search . '%')
            ))

            // Filter theo category
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))

            // Filter theo status
            ->when($request->status, fn($q) => $q->where('status', $request->status))

            // Phân quyền xem
            ->when(
                !in_array($user->role, ['hr', 'manager', 'admin']),
                fn($q) => $q->where(fn($q2) => $q2
                    ->where('employee_id', $user->id)
                    ->orWhere(fn($q3) => $q3->whereNull('employee_id')->where('is_confidential', false))
                )
            )

            // Sort
            ->when($request->sort === 'oldest', fn($q) => $q->oldest())
            ->when($request->sort === 'name',   fn($q) => $q->orderBy('file_name'))
            ->when($request->sort === 'size',   fn($q) => $q->orderBy('file_size', 'desc'))
            ->when(!$request->sort || $request->sort === 'newest', fn($q) => $q->latest())

            ->paginate(15)
            ->withQueryString(); // giữ query string khi phân trang

        $categories = \App\packages\Nova\document\src\Models\DocumentCategory::active()
            ->orderBy('order')
            ->get();

        return view('documents::index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = \App\packages\Nova\document\src\Models\DocumentCategory::active()
            ->orderBy('order')
            ->get();

        return view('documents::create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',  
            'file'            => 'required|file|mimes:pdf|max:20480',
            'category_id'     => 'required|exists:document_categories,id',
            'employee_id'     => 'nullable|exists:employees,id',
            'tags'            => 'nullable|array',
            'is_confidential' => 'boolean',
            'issued_at'       => 'nullable|date',
            'expires_at'      => 'nullable|date|after:issued_at',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'local');

        Document::create([
            'title'           => $data['title'],
            'category_id'     => $data['category_id'],
            'employee_id'     => $data['employee_id'] ?? null,
            'uploaded_by'     => $request->user()->id, 
            'file_name'       => $file->getClientOriginalName(),
            'tags'            => $data['tags'] ?? null,
            'is_confidential' => $data['is_confidential'] ?? false,
            'issued_at'       => $data['issued_at'] ?? null,
            'expires_at'      => $data['expires_at'] ?? null,
            'file_path'       => $path,
            'file_mime'       => $file->getMimeType(),
            'file_size'       => $file->getSize(),
            'status'          => 'draft',
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Đã tạo tài liệu thành công.');
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);

        $document->load(['category', 'employee', 'approvals.actor', 'signatures']);

        return view('documents::show', compact('document'));
    }

    public function edit(Document $document)
    {
        $this->authorize('update', $document);

        $categories = \App\packages\Nova\document\src\Models\DocumentCategory::active()
            ->orderBy('order')
            ->get();

        $employees = \Nova\Auth\Models\Employee::orderBy('first_name')->get();

        return view('documents::edit', compact('document', 'categories', 'employees'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        if ($document->status !== 'draft') {
            return redirect()
                ->back()
                ->with('error', 'Chỉ sửa được tài liệu ở trạng thái nháp.');
        }

        // Parse tags từ JSON string thành array
        if ($request->has('tags') && is_string($request->tags)) {
            $request->merge([
                'tags' => json_decode($request->tags, true) ?? []
            ]);
        }

        $document->update($request->validate([
            'file_name'       => 'nullable|string',
            'category_id'     => 'nullable|exists:document_categories,id',
            'employee_id'     => 'nullable|exists:employees,id',
            'tags'            => 'nullable|array',
            'is_confidential' => 'boolean',
            'issued_at'       => 'nullable|date',
            'expires_at'      => 'nullable|date',
            'version'         => 'nullable|integer|min:1',
        ]));

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Đã cập nhật tài liệu thành công.');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        if ($document->status !== 'draft') {
            return redirect()
                ->back()
                ->with('error', 'Không thể xóa tài liệu đã xử lý.');
        }

        Storage::disk('local')->delete($document->file_path);

        if ($document->signed_file_path) {
            Storage::disk('local')->delete($document->signed_file_path);
        }

        $document->delete();

        return redirect()
            ->route('documents.index')
            ->with('success', 'Đã xóa tài liệu.');
    }

    public function download(Document $document, string $type = 'original')
    {
        $this->authorize('view', $document);

        $path = ($type === 'signed' && $document->signed_file_path)
            ? $document->signed_file_path
            : $document->file_path;

        if (!Storage::disk('local')->exists($path)) {
            return redirect()
                ->back()
                ->with('error', 'File không tồn tại trên hệ thống.');
        }

        return response()->download(Storage::disk('local')->path($path),$document->file_name);
    }

    public function submitForApproval(Document $document)
    {
        $this->authorize('update', $document);

        if (!in_array($document->status, ['draft', 'rejected'])) {
            return redirect()
                ->back()
                ->with('error', 'Không thể gửi duyệt ở trạng thái này.');
        }

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = request()->user();

        $document->update(['status' => 'pending']);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $employee->id,
            'action'      => 'submitted',
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Đã gửi tài liệu để phê duyệt.');
    }

    public function preview(Document $document)
    {
        $this->authorize('view', $document);

        $type = request('type', 'signed');

        $filePath = ($type === 'original' || !$document->signed_file_path)
            ? $document->file_path
            : $document->signed_file_path;

        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'File không tồn tại.');
        }

        $fileContent = Storage::disk('local')->get($filePath);

        return response($fileContent, 200, [
            'Content-Type'        => $document->file_mime ?? 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"',
            'Content-Length'      => strlen($fileContent),
            'Cache-Control'       => 'no-store, no-cache',
            'X-Frame-Options'     => 'SAMEORIGIN',
        ]);
    }
}