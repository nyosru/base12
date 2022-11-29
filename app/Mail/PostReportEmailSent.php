<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class PostReportEmailSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $message;
    private $from_emal;
    private $from_fn;

    public function __construct($from_email,$from_fn,$subject,$message)
    {
        $this->message = $message;
        $this->from_fn=$from_fn;
        $this->from_emal=$from_email;
        $this->subject=$subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->from_emal,$this->from_fn)
            ->subject($this->subject)
            ->view('post-report-email.email')
            ->with(['email' => $this->message]);
    }
}
