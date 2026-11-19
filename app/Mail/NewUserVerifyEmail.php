<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserVerifyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    public function __construct($user, $verificationUrl)
    {
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-user-verify-email', // Correct view name
            with: [
                'user' => $this->user,
                'verificationUrl' => $this->verificationUrl,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
