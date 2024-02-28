<?php

namespace App\Models;

use App\Enums\TransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'transaction_id', 'ticket_id', 'customer_name', 'customer_email', 'customer_phone', 'customer_group',
        'ticket_price', 'transaction_date', 'transaction_status',
    ];

    protected $casts = [
        'transaction_status' => TransactionStatusEnum::class,
    ];

    /**
     * Get the ticket associated with the ticket.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the user that owns the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the latest payment for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }
}
