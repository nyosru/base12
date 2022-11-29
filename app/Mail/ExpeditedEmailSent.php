<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;


class ExpeditedEmailSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $message;
    private $from_email;
    private $from_fn;

    public function __construct($from_email,$from_fn,$subject,$message)
    {
        $this->message = $message;
        $this->from_fn=$from_fn;
        $this->from_email=$from_email;
        $this->subject=$subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->from_email,$this->from_fn)
            ->subject($this->subject)
            ->view('payments-calendar.email')
            ->with(['email' => $this->message]);
    }
}
