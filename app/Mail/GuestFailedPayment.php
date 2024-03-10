<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GuestFailedPayment extends Mailable
{
    use Queueable, SerializesModels;

    private Transaction $transaction;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Gagal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content('layouts.email.guest.payment_failed',
            with: [
                'transaction' => $this->transaction
            ]
        );
    }
}
