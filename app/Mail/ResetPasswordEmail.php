<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use SerializesModels;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('emails.reset-password')
            ->with(['resetLink' => $this->token])
            ->subject('Resetowanie hasła');
    }
}
