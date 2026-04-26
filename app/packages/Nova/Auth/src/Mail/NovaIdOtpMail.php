<?php

namespace Nova\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NovaIdOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly string $otp) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Mã OTP đăng nhập Nova ID');
    }

    public function content(): Content
    {
        return new Content(
            view: 'nova-auth::emails.otp',
            with: ['otp' => $this->otp],
        );
    }
}