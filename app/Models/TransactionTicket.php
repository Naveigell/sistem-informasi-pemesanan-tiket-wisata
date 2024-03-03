<?php

namespace App\Models;

use App\Traits\CanSaveFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Ramsey\Uuid\Uuid;

class TransactionTicket extends Model
{
    use HasFactory, CanSaveFile {
        saveFile as saveFileTrait;
    }

    protected $fillable = [
        'transaction_id', 'transaction_code', 'name', 'price', 'group', 'ticket_code', 'qr_code_image',
        'transaction_date',
    ];

    /**
     * Get the transaction ticket associated with the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(TransactionTicket::class);
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

}
