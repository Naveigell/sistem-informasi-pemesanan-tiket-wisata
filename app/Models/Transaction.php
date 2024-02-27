<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'transaction_id', 'ticket_id', 'customer_name', 'customer_email', 'customer_phone', 'customer_group',
        'ticket_price', 'transaction_date', 'transaction_status',
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
}
