<?php

namespace Nova\document\Services;

use Nova\document\Http\Requests\StoreDocumentRequest;
use Nova\document\Http\Requests\UpdateDocumentRequest;
use Nova\document\Models\Document;
use Nova\document\Models\DocumentApproval;
use Nova\document\Models\DocumentCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nova\Auth\Models\Employee;

class DocumentService
{
    public function list(Request $request, Employee $user): LengthAwarePaginator
    {
        return Document::with('category')
            ->when($request->tab === 'personal', fn($q) => $q->where('employee_id', $user->id))
            ->when($request->tab === 'company',  fn($q) => $q->whereNull('employee_id'))
            ->when($request->tab === 'pending',  fn($q) => $q->where('status', 'pending'))
            ->when($request->tab === 'signing',  fn($q) => $q->where('status', 'signing'))
            ->when($request->search, fn($q) => $q->where(fn($q2) => $q2
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('file_name', 'like', '%' . $request->search . '%')
            ))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->status,   fn($q) => $q->where('status', $request->status))
            ->when(
                !in_array($user->role, ['hr', 'manager', 'admin']),
                fn($q) => $q->where(fn($q2) => $q2
                    ->where('employee_id', $user->id)
                    ->orWhere(fn($q3) => $q3->whereNull('employee_id')->where('is_confidential', false))
                )
            )
            ->when($request->sort === 'oldest', fn($q) => $q->oldest())
            ->when($request->sort === 'name',   fn($q) => $q->orderBy('file_name'))
            ->when($request->sort === 'size',   fn($q) => $q->orderBy('file_size', 'desc'))
            ->when(!$request->sort || $request->sort === 'newest', fn($q) => $q->latest())
            ->paginate(15)
            ->withQueryString();
    }

    public function store(StoreDocumentRequest $request): Document
    {
        $data = $request->validated();
        $file = $request->file('file');
        $path = $file->store('documents', 'local');

        return Document::create([
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
    }

    public function update(UpdateDocumentRequest $request, Document $document): bool
    {
        return $document->update($request->validated());
    }

    public function destroy(Document $document): void
    {
        Storage::disk('local')->delete($document->file_path);

        if ($document->signed_file_path) {
            Storage::disk('local')->delete($document->signed_file_path);
        }

        $document->delete();
    }

    public function submitForApproval(Document $document, Employee $employee): void
    {
        $document->update(['status' => 'pending']);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $employee->id,
            'action'      => 'submitted',
        ]);
    }

    public function getDownloadPath(Document $document, string $type = 'original'): string
    {
        return ($type === 'signed' && $document->signed_file_path)
            ? $document->signed_file_path
            : $document->file_path;
    }

    public function getPreviewPath(Document $document, string $type = 'signed'): string
    {
        return ($type === 'original' || !$document->signed_file_path)
            ? $document->file_path
            : $document->signed_file_path;
    }
}