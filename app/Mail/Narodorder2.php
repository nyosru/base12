<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Narodorder2 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            // ->from('support1@uralweb.info')
            // ->from('1@uralweb.info', 'Example')
            // ->markdown('emails.narodorder2')
            // ->view('emails.orders.shipped')
            // ->view('narod::emails.narodorder2')
            ->view('emails.narodorder2')
            // ->text('emails.narodorder2_plain')
            ;
    }
}
