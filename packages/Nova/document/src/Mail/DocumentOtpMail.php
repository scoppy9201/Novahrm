<?php

namespace Nova\document\Mail;

use Nova\document\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Document $document,
        public int $otp
    ) {}

    public function build()
    {
        return $this->subject('Mã OTP ký tài liệu: ' . $this->document->title)
                    ->markdown('documents::emails.document-otp');
    }
}