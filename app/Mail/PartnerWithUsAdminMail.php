<?php

namespace App\Mail;

use App\Models\PartnerWithUsForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerWithUsAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    public function __construct(PartnerWithUsForm $form)
    {
        $this->form = $form;
    }

    public function build()
    {
        return $this->subject('New Partner With Us Submission')
            ->view('emails.partner_with_us_admin');
    }
}
