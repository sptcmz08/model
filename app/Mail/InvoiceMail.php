<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public ?string $invoiceNote;

    public function __construct(Order $order, ?string $invoiceNote = null)
    {
        $this->order = $order;
        $this->invoiceNote = $invoiceNote;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice #' . $this->order->order_number . ' - tattooink12studio.com',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice',
            with: [
                'order' => $this->order,
                'invoiceNote' => $this->invoiceNote,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
