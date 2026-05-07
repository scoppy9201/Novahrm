<?php

namespace Nova\document\Http\Controllers;

use Nova\document\Http\Requests\StoreDocumentRequest;
use Nova\document\Http\Requests\UpdateDocumentRequest;
use Nova\document\Models\Document;
use Nova\document\Models\DocumentCategory;
use Nova\document\Services\DocumentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Nova\Auth\Models\Employee;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly DocumentService $service
    ) {}

    public function index(Request $request)
    {
        /** @var Employee $user */
        $user = $request->user();

        $documents  = $this->service->list($request, $user);
        $categories = DocumentCategory::active()->orderBy('order')->get();

        return view('documents::index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = DocumentCategory::active()->orderBy('order')->get();

        return view('documents::create', compact('categories'));
    }

    public function store(StoreDocumentRequest $request)
    {
        $this->service->store($request);

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

        $categories = DocumentCategory::active()->orderBy('order')->get();
        $employees  = \Nova\Auth\Models\Employee::orderBy('first_name')->get();

        return view('documents::edit', compact('document', 'categories', 'employees'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $this->authorize('update', $document);

        if ($document->status !== 'draft') {
            return redirect()->back()->with('error', 'Chỉ sửa được tài liệu ở trạng thái nháp.');
        }

        $this->service->update($request, $document);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Đã cập nhật tài liệu thành công.');
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        if ($document->status !== 'draft') {
            return redirect()->back()->with('error', 'Không thể xóa tài liệu đã xử lý.');
        }

        $this->service->destroy($document);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Đã xóa tài liệu.');
    }

    public function download(Document $document, Request $request)
    {
        $this->authorize('view', $document);

        $path = $this->service->getDownloadPath($document, $request->query('type', 'original'));

        if (!Storage::disk('local')->exists($path)) {
            return redirect()->back()->with('error', 'File không tồn tại trên hệ thống.');
        }

        return response()->download(Storage::disk('local')->path($path), $document->file_name);
    }

    public function submitForApproval(Document $document, Request $request)
    {
        $this->authorize('update', $document);

        if (!in_array($document->status, ['draft', 'rejected'])) {
            return redirect()->back()->with('error', 'Không thể gửi duyệt ở trạng thái này.');
        }

        $this->service->submitForApproval($document, $request->user());

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Đã gửi tài liệu để phê duyệt.');
    }

    public function preview(Document $document, Request $request)
    {
        $this->authorize('view', $document);

        $filePath = $this->service->getPreviewPath($document, $request->query('type', 'signed'));

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