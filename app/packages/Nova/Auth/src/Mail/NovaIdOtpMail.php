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

    public function __construct(
        public readonly string $otp,
        public readonly string $email = '',
        public readonly string $type = 'login' // 'login' | 'forgot_password'
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->type === 'forgot_password'
            ? 'Mã OTP đặt lại mật khẩu — NovaHRM'
            : 'Mã OTP đăng nhập Nova ID — NovaHRM';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'nova-auth::otp',
            with: [
                'otp'   => $this->otp,
                'email' => $this->email,
                'type'  => $this->type,
            ],
        );
    }
}