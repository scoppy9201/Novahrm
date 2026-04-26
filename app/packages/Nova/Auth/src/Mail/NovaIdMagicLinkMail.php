<?php

namespace Nova\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NovaIdMagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly string $link) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Liên kết đăng nhập Nova ID');
    }

    public function content(): Content
    {
        return new Content(
            view: 'nova-auth::emails.magic-link',
            with: ['link' => $this->link],
        );
    }
}