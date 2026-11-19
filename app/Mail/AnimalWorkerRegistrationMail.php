<?php

namespace App\Mail;

use App\Models\AnimalWorkerRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnimalWorkerRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $forAdmin;

    /**
     * Create a new message instance.
     */
    public function __construct(AnimalWorkerRegistration $record, bool $forAdmin = false)
    {
        $this->record = $record;
        $this->forAdmin = $forAdmin;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->subject(
            $this->forAdmin
                ? 'New Animal Worker Registration Received'
                : 'Thank You for Registering as an Animal Worker'
        );

        $mail->view('emails.animal_worker.registration');

        // Attach proof file (only for admin)
        if ($this->forAdmin && $this->record->statusproof) {
            $mail->attach(storage_path('app/public/' . $this->record->statusproof));
        }

        return $mail;
    }
}
