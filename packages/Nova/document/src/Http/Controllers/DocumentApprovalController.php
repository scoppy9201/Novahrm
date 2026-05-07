<?php

namespace Nova\document\Http\Controllers;

use Nova\document\Http\Requests\ApproveDocumentRequest;
use Nova\document\Http\Requests\RejectDocumentRequest;
use Nova\document\Http\Requests\RequestRevisionRequest;
use Nova\document\Models\Document;
use Nova\document\Services\DocumentApprovalService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class DocumentApprovalController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly DocumentApprovalService $service
    ) {}

    public function index(Document $document)
    {
        $this->authorize('approve', $document);

        $approvals = $document->approvals()->with('actor')->latest()->get();

        return view('documents::approvals.index', compact('document', 'approvals'));
    }

    public function approve(ApproveDocumentRequest $request, Document $document)
    {
        $this->authorize('approve', $document);

        if ($document->status !== 'pending') {
            return redirect()->back()->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $this->service->approve($document, $request->user()->id, $request->note);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Tài liệu đã được phê duyệt.');
    }

    public function reject(RejectDocumentRequest $request, Document $document)
    {
        $this->authorize('approve', $document);

        if ($document->status !== 'pending') {
            return redirect()->back()->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $this->service->reject($document, $request->user()->id, $request->note);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Tài liệu đã bị từ chối.');
    }

    public function requestRevision(RequestRevisionRequest $request, Document $document)
    {
        $this->authorize('approve', $document);

        if ($document->status !== 'pending') {
            return redirect()->back()->with('error', 'Tài liệu không ở trạng thái chờ duyệt.');
        }

        $this->service->requestRevision($document, $request->user()->id, $request->note);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Đã yêu cầu chỉnh sửa tài liệu.');
    }
}