<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    // private $token;
    public $url;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $url = env('VUE_APP_URL');
        $this->email = request()->email;
        $this->url = "${url}/reset-password/${token}";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.forgetPassword')->to($this->email);
    }
}
