<?php

namespace App\Models;

use App\Enums\TicketGroupEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price',
    ];
}
