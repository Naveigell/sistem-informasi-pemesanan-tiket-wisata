<?php

namespace App\Models;

use App\Enums\TransactionStatusEnum;
use App\Interfaces\HasQrCode;
use App\Interfaces\HasUuid;
use App\Jobs\SendGuestTicketOrderJob;
use App\Traits\CanSaveFile;
use App\Traits\HasClass;
use App\Traits\Transaction\CanConstructUrlForQrCode;
use App\Utils\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Ramsey\Uuid\Uuid;

class Transaction extends Model implements HasQrCode, HasUuid
{
    use HasFactory, HasClass, CanConstructUrlForQrCode, CanSaveFile {
        CanSaveFile::saveFile as saveFileTrait;
    }

    protected $fillable = [
        'user_id', 'transaction_id', 'ticket_id', 'transaction_code', 'customer_name', 'customer_email', 'customer_phone',
        'customer_group', 'ticket_price', 'booking_date', 'number_of_tickets', 'qr_code_image', 'transaction_status',
    ];

    protected $casts = [
        'transaction_status' => TransactionStatusEnum::class,
        'booking_date' => 'date',
    ];

    public function sendEmail()
    {
        // only send email if this transaction not belongs to any user
        if ($this->isDoesntHaveLoggedUser()) {
            dispatch(new SendGuestTicketOrderJob($this));
        }
    }

    /**
     * Determine if this transaction not belongs to any user
     *
     * @return bool
     */
    public function isDoesntHaveLoggedUser()
    {
        return !$this->user_id;
    }

    /**
     * Get the user that owns the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a relationship with the TransactionTicket model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionTickets()
    {
        return $this->hasMany(TransactionTicket::class);
    }

    /**
     * Get the latest payment for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestPayment()
    {
        return $this->payment()->latest();
    }

    /**
     * Define a relationship between the user and their payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getQrCodeImageUrlAttribute()
    {
        if (file_exists(storage_path("app/{$this->qrCodeImagePath()}/{$this->qr_code_image}"))) {
            return asset("storage/qr_codes/{$this->qr_code_image}");
        }

        return "https://placehold.co/600x400";
    }

    public function qrCodeImagePath()
    {
        return $this->fullPath() . '/qr_codes';
    }

    /**
     * Save file to storage and set the attribute value.
     *
     * @param string $attribute
     * @param mixed $value
     * @param string $path
     * @param string|null $extension
     * @return void
     */
    public function saveFile($attribute, $value, $path, $extension = 'png')
    {
        // this is for qr code, we don't want to add it on parent method
        if ($value instanceof HtmlString) {
            $filename = Uuid::uuid4()->toString() . '-' . uniqid() . ".{$extension}";

            // Construct the file path
            $filepath = trim($path, '/') . '/' . trim($filename, '/');

            // Save the QR code image to the specified path
            Storage::put($filepath, $value);

            // Set the attribute value to the filename
            $this->attributes[$attribute] = $filename;
        } else {
            $this->saveFileTrait($attribute, $value, $path, $extension);
        }
    }

    /**
     * Set the number of tickets attribute.
     *
     * @param  int  $value
     * @return void
     */
    public function setNumberOfTicketAttribute($value)
    {
        $this->attributes['number_of_tickets'] = $value;
    }

    /**
     * Generate a new UUID.
     *
     * @return void
     */
    public function generateUuid()
    {
        $this->attributes['transaction_code'] = Uuid::uuid4()->toString();
    }

    /**
     * Generates a QR code.
     */
    public function generateQrCode()
    {
        // generate qr code
        $this->saveFile('qr_code_image', QrCode::createQrCodeImage($this->constructValidateQrCodeUrl()), $this->qrCodeImagePath());
    }
}
