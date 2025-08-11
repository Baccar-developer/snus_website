<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class facture extends Mailable
{
    use Queueable, SerializesModels;

    private $cart_elements;
    private $full_price;
    public function __construct($cart_elements ,$full_price)
    {
        $this->cart_elements =$cart_elements;
        $this->full_price = $full_price;
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'order sent is succeded!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'auth.order_succeded',
            with: ["cart_elements" =>$this->cart_elements , "full_price"=>$this->full_price]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
