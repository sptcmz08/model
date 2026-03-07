<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrackingCorrectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $oldTracking;

    public function __construct(Order $order, string $oldTracking)
    {
        $this->order = $order;
        $this->oldTracking = $oldTracking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Important: Tracking Number Correction - Order #' . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tracking-correction',
            with: [
                'order' => $this->order,
                'oldTracking' => $this->oldTracking,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
