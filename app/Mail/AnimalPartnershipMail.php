<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnimalPartnershipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $forAdmin;

    public function __construct($data, $forAdmin = false)
    {
        $this->data = $data;
        $this->forAdmin = $forAdmin;
    }

    public function build()
    {
        if ($this->forAdmin) {
            $subject = 'New Animal Partnership Application Received';
            $view = 'emails.animalpartnership_admin';
        } else {
            $subject = 'Your Animal Partnership Application Confirmation';
            $view = 'emails.animalpartnership_user';
        }

        return $this->subject($subject)
                    ->view($view)
                    ->with('data', $this->data);
    }
}
