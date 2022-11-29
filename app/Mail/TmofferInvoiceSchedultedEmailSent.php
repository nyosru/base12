<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class TmofferInvoiceSchedultedEmailSent extends Mailable
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
    private $invoice_pdf;

    public function __construct($from_email,$from_fn,$subject,$message,$invoice_pdf)
    {
        $this->message = $message;
        $this->from_fn=$from_fn;
        $this->from_email=$from_email;
        $this->subject=$subject;
        $this->invoice_pdf=$invoice_pdf;
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
            ->with(['email' => $this->message])
            ->attach($this->invoice_pdf);
    }
}
