<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->data=$token;
    }

  
    public function build()
    {
        $data=$this->data;
        return $this->from('tarek0aziz@gmail.com')->view('Mail.forgot', compact('data'))->subject('Password Reset link');
    }
}
