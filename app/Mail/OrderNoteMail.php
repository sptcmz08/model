<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderNoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $note;

    public function __construct(Order $order, string $note)
    {
        $this->order = $order;
        $this->note = $note;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Update #' . $this->order->order_number . ' - tattooink12studio.com',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-note',
            with: [
                'order' => $this->order,
                'note' => $this->note,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
