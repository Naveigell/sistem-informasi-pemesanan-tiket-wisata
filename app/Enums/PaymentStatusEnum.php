<?php

namespace App\Enums;

use App\Enums\Interfaces\HasLabel;

enum PaymentStatusEnum: string implements HasLabel
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    /**
     * Returns the label for this enum.
     */
    public function toLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu',
            self::SUCCESS => 'Berhasil',
            self::FAILED => 'Gagal',
        };
    }
}
