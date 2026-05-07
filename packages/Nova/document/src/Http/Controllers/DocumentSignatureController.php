<?php

namespace Nova\document\Http\Controllers;

use Nova\document\Http\Requests\SignDocumentRequest;
use Nova\document\Models\Document;
use Nova\document\Services\DocumentSignatureService;
use Illuminate\Routing\Controller;

class DocumentSignatureController extends Controller
{
    public function __construct(
        private readonly DocumentSignatureService $service
    ) {}

    public function show(Document $document)
    {
        $this->authorize('view', $document);

        $signature = $document->signatures()->latest()->first();

        if (!$signature) {
            return redirect()->back()->with('error', 'Tài liệu chưa được ký.');
        }

        return view('documents::signature.show', compact('document', 'signature'));
    }

    public function sendOtp(Document $document)
    {
        if (!$document->canBeSigned()) {
            return response()->json(['message' => 'Tài liệu chưa sẵn sàng để ký.'], 422);
        }

        $this->service->sendOtp($document, request()->user());

        return response()->json(['message' => 'OTP đã gửi về email của bạn.']);
    }

    public function sign(SignDocumentRequest $request, Document $document)
    {
        if (!$document->canBeSigned()) {
            return redirect()->back()->with('error', 'Tài liệu chưa sẵn sàng để ký.');
        }

        $employee  = $request->user();
        $otpRecord = $this->service->verifyOtp($document, $employee, $request->otp);

        if (!$otpRecord) {
            return redirect()->back()->with('error', 'OTP không hợp lệ hoặc đã hết hạn.');
        }

        $this->service->sign($document, $employee, $otpRecord, array_merge(
            $request->validated(),
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        ));

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Tài liệu đã được ký thành công.');
    }
}