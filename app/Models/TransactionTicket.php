<?php

namespace App\Models;

use App\Enums\TicketGroupEnum;
use App\Enums\TransactionStatusEnum;
use App\Interfaces\HasQrCode;
use App\Interfaces\HasUuid;
use App\Traits\CanSaveFile;
use App\Traits\HasClass;
use App\Traits\Transaction\CanConstructUrlForQrCode;
use App\Utils\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Ramsey\Uuid\Uuid;

class TransactionTicket extends Model implements HasUuid, HasQrCode
{
    use HasFactory, HasClass, CanConstructUrlForQrCode, CanSaveFile {
        CanSaveFile::saveFile as saveFileTrait;
    }

    protected $fillable = [
        'transaction_id', 'transaction_code', 'name', 'price', 'group', 'ticket_code', 'qr_code_image', 'quantity', 'status',
    ];

    protected $casts = [
        'group' => TicketGroupEnum::class,
        'status' => TransactionStatusEnum::class,
    ];

    /**
     * Get the transaction ticket associated with the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Set the total ticket attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
    }

    /**
     * Get the URL for the QR code image attribute.
     *
     * @return string|null
     */
    public function getQrCodeImageUrlAttribute()
    {
        // Check if the QR code image file exists
        if (file_exists(storage_path("app/{$this->qrCodeImagePath()}/{$this->qr_code_image}"))) {
            // Return the URL for the QR code image
            return asset("storage/qr_codes/{$this->qr_code_image}");
        }
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
     * Get the QR code image path.
     *
     * @return string
     */
    public function qrCodeImagePath()
    {
        return $this->fullPath() . '/qr_codes';
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
