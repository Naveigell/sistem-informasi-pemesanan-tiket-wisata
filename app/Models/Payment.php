<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Traits\CanSaveFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, CanSaveFile;

    protected $fillable = [
        'transaction_id', 'payment_proof_image', 'payment_method', 'payment_status',
    ];

    protected $casts = [
        'payment_method' => PaymentMethodEnum::class,
        'payment_status' => PaymentStatusEnum::class,
    ];

    public function getPaymentProofImageUrlAttribute()
    {
        if (file_exists(storage_path("app/{$this->fullPath()}/{$this->payment_proof_image}"))) {
            return asset("storage/payments/{$this->payment_proof_image}");
        }

        return "https://placehold.co/600x400";
    }

    /**
     * Get the transaction associated with the transaction.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Return the full path where the file will be saved
     *
     * @return string
     */
    public function fullPath()
    {
        return $this->options['root_folder'] . '/payments';
    }
}
