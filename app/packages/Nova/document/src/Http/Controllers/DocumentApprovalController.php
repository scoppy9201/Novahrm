<?php

namespace App\packages\Nova\document\src\Http\Controllers;

use App\packages\Nova\document\src\Models\Document;
use App\packages\Nova\document\src\Models\DocumentApproval;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class DocumentApprovalController extends Controller
{
    use AuthorizesRequests;

    public function index(Document $document)
    {
        $this->authorize('approve', $document);

        $approvals = $document->approvals()->with('actor')->latest()->get();

        return view('documents::approvals.index', compact('document', 'approvals'));
    }

    public function approve(Request $request, Document $document)
    {
        $this->authorize('approve', $document);

        if ($document->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $nextStatus = $document->category->requires_signature ? 'signing' : 'approved';
        $document->update(['status' => $nextStatus]);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $request->user()->id,
            'action'      => 'approved',
            'note'        => $request->note,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Tài liệu đã được phê duyệt.');
    }

    public function reject(Request $request, Document $document)
    {
        $this->authorize('approve', $document);

        $request->validate(['note' => 'nullable|string|max:1000']);

        if ($document->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $document->update(['status' => 'rejected']);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $request->user()->id,
            'action'      => 'rejected',
            'note'        => $request->note,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Tài liệu đã bị từ chối.');
    }

    public function requestRevision(Request $request, Document $document)
    {
        $this->authorize('approve', $document);

        $request->validate(['note' => 'required|string|max:1000']);

        if ($document->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $document->update(['status' => 'draft']);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $request->user()->id,
            'action'      => 'revision_requested',
            'note'        => $request->note,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Đã yêu cầu chỉnh sửa tài liệu.');
    }
}