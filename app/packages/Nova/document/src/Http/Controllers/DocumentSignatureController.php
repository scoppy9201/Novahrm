<?php

namespace App\packages\Nova\document\src\Http\Controllers;

use App\packages\Nova\document\src\Mail\DocumentOtpMail;
use App\packages\Nova\document\src\Models\Document;
use App\packages\Nova\document\src\Models\DocumentOtp;
use App\packages\Nova\document\src\Models\DocumentSignature;
use App\Services\PdfSignatureService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class DocumentSignatureController extends Controller
{
    public function show(Document $document)
    {
        $this->authorize('view', $document);

        $signature = $document->signatures()->latest()->first();

        if (!$signature) {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu chưa được ký.');
        }

        return view('documents::signature.show', compact('document', 'signature'));
    }

    public function sendOtp(Document $document)
    {
        if (!$document->canBeSigned()) {
            return response()->json([
                'message' => 'Tài liệu chưa sẵn sàng để ký.'
            ], 422);
        }

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = request()->user();

        $otp = random_int(100000, 999999);

        DocumentOtp::where('document_id', $document->id)->update(['is_used' => true]);

        DocumentOtp::create([
            'document_id' => $document->id,
            'employee_id' => $employee->id,
            'otp'         => bcrypt($otp),
            'expires_at'  => now()->addMinutes(10),
            'is_used'     => false,
        ]);

        Mail::to($employee->email)->send(new DocumentOtpMail($document, $otp));

        return response()->json([
            'message' => 'OTP đã gửi về email của bạn.'
        ]);
    }

    public function sign(Request $request, Document $document)
    {
        $request->validate([
            'otp'             => 'required|string|size:6',
            'signature_image' => 'required|string',
            'page_number'     => 'required|integer|min:1',
            'pos_x'           => 'required|numeric',
            'pos_y'           => 'required|numeric',
            'width'           => 'nullable|numeric',
            'height'          => 'nullable|numeric',
        ]);

        if (!$document->canBeSigned()) {
            return redirect()
                ->back()
                ->with('error', 'Tài liệu chưa sẵn sàng để ký.');
        }

        /** @var \Nova\Auth\Models\Employee $employee */
        $employee = request()->user();

        $otpRecord = DocumentOtp::where('document_id', $document->id)
            ->where('employee_id', $employee->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otpRecord || !$otpRecord->isValid() || !password_verify($request->otp, $otpRecord->otp)) {
            return redirect()
                ->back()
                ->with('error', 'OTP không hợp lệ hoặc đã hết hạn.');
        }

        $otpRecord->update(['is_used' => true, 'otp_verified_at' => now()]);
        // Nhúng chữ ký vào PDF
        $signedPath = app(PdfSignatureService::class)->embedSignature(
            filePath:        $document->file_path,
            signatureBase64: $request->signature_image,
            pageNumber:      (int) $request->page_number,
            posX:            (float) $request->pos_x,
            posY:            (float) $request->pos_y,
            width:           (float) ($request->width  ?? 80),
            height:          (float) ($request->height ?? 30),
        );

        DocumentSignature::create([
            'document_id'     => $document->id,
            'employee_id'     => $employee->id,
            'signature_image' => $request->signature_image,
            'ip_address'      => $request->ip(),
            'user_agent'      => $request->userAgent(),
            'signed_at'       => now(),
            'page_number'     => $request->page_number,
            'pos_x'           => $request->pos_x,
            'pos_y'           => $request->pos_y,
            'width'           => $request->width  ?? 80,
            'height'          => $request->height ?? 30,
        ]);

        $document->update([
            'status'           => 'signed',
            'signed_file_path' => $signedPath,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Tài liệu đã được ký thành công.');
    }
}