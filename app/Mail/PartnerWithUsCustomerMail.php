<?php

namespace App\Mail;

use App\Models\PartnerWithUsForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerWithUsCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    public function __construct(PartnerWithUsForm $form)
    {
        $this->form = $form;
    }

    public function build()
    {
        return $this->subject('Thank You for Partnering with Zoiko Mobile')
            ->view('emails.partner_with_us_customer');
    }
}
