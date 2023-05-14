<?php

namespace App\Mail;

use App\Models\Order_summery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Order_placedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order_summery;

    public function __construct(Order_summery $order_summery)
    {
        $this->order_summery = $order_summery;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Order Placed Success Mail',
        );
    }

    public function content()
    {
        return new Content(
            view: 'admin.mail.order-placed',
        );
    }

    public function attachments()
    {
        return [];
    }
}
