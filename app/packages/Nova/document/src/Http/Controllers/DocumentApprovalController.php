<?php

namespace App\packages\Nova\document\src\Http\Controllers;

use App\packages\Nova\document\src\Models\Document;
use App\packages\Nova\document\src\Models\DocumentApproval;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DocumentApprovalController extends Controller
{
    public function index(Document $document)
    {
        $approvals = $document->approvals()->with('actor')->latest()->get();

        return view('documents::approvals.index', compact('document', 'approvals'));
    }

    public function approve(Request $request, Document $document)
    {
        if ($document->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $nextStatus = $document->category->requires_signature ? 'signing' : 'approved';
        $document->update(['status' => $nextStatus]);

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = $request->user();

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $employee->id,
            'action'      => 'approved',  
            'note'        => $request->note,
        ]);

        return redirect()
            ->route('documents::approvals.index', $document)
            ->with('success', 'Tài liệu đã được phê duyệt.');
    }

    public function reject(Request $request, Document $document)
    {
        $request->validate(['note' => 'nullable|string|max:1000']);

        if ($document->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $document->update(['status' => 'rejected']);

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = $request->user();

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $employee->id,
            'action'      => 'rejected',  
            'note'        => $request->note,
        ]);

        return redirect()
            ->route('documents::approvals.index', $document)
            ->with('success', 'Tài liệu đã bị từ chối.');
    }

    public function requestRevision(Request $request, Document $document)
    {
        $request->validate(['note' => 'required|string|max:1000']);

        if ($document->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $document->update(['status' => 'draft']);

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = $request->user();

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $employee->id,
            'action'      => 'revision_requested',  
            'note'        => $request->note,
        ]);

        return redirect()
            ->route('documents::approvals.index', $document)
            ->with('success', 'Đã yêu cầu chỉnh sửa tài liệu.');
    }
}