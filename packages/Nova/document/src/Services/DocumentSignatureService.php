<?php

namespace Nova\document\Services;

use Nova\document\Mail\DocumentOtpMail;
use Nova\document\Models\Document;
use Nova\document\Models\DocumentOtp;
use Nova\document\Models\DocumentSignature;
use App\Services\PdfSignatureService;
use Illuminate\Support\Facades\Mail;
use Nova\Auth\Models\Employee;

class DocumentSignatureService
{
    public function __construct(
        private readonly PdfSignatureService $pdfSignatureService
    ) {}

    public function sendOtp(Document $document, Employee $employee): void
    {
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
    }

    public function verifyOtp(Document $document, Employee $employee, string $otp): ?DocumentOtp
    {
        $record = DocumentOtp::where('document_id', $document->id)
            ->where('employee_id', $employee->id)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$record || !$record->isValid() || !password_verify($otp, $record->otp)) {
            return null;
        }

        return $record;
    }

    public function sign(Document $document, Employee $employee, DocumentOtp $otpRecord, array $data): void
    {
        $otpRecord->update(['is_used' => true, 'otp_verified_at' => now()]);

        $signedPath = $this->pdfSignatureService->embedSignature(
            filePath:        $document->file_path,
            signatureBase64: $data['signature_image'],
            pageNumber:      (int) $data['page_number'],
            posX:            (float) $data['pos_x'],
            posY:            (float) $data['pos_y'],
            width:           (float) ($data['width']  ?? 80),
            height:          (float) ($data['height'] ?? 30),
        );

        DocumentSignature::create([
            'document_id'     => $document->id,
            'employee_id'     => $employee->id,
            'signature_image' => $data['signature_image'],
            'ip_address'      => $data['ip_address'],
            'user_agent'      => $data['user_agent'],
            'signed_at'       => now(),
            'page_number'     => $data['page_number'],
            'pos_x'           => $data['pos_x'],
            'pos_y'           => $data['pos_y'],
            'width'           => $data['width']  ?? 80,
            'height'          => $data['height'] ?? 30,
        ]);

        $document->update([
            'status'           => 'signed',
            'signed_file_path' => $signedPath,
        ]);
    }
}