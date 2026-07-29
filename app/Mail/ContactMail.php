<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $subjectLine,
        public readonly string $message,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name'),
            ),
            replyTo: [new Address($this->email, $this->name)],
            subject: '[Contact] '.$this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'subjectLine' => $this->subjectLine,
                'message' => $this->message,
            ],
        );
    }
}
