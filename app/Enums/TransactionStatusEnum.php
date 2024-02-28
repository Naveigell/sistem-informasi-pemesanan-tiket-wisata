<?php

namespace App\Enums;

use App\Enums\Interfaces\HasHtmlBadge;
use App\Enums\Interfaces\HasLabel;

enum TransactionStatusEnum: string implements HasLabel, HasHtmlBadge
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    /**
     * Check if the status is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->value == self::PENDING->value;
    }

    /**
     * Returns the label for this enum.
     */
    public function toLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::FAILED => 'Failed',
        };
    }

    /**
     * Convert the data to a html badge.
     */
    public function toHtmlBadge()
    {
        return match ($this) {
            self::PENDING => '<span class="badge badge-light">' . $this->toLabel() . '</span>',
            self::SUCCESS => '<span class="badge badge-success">' . $this->toLabel() . '</span>',
            self::FAILED => '<span class="badge badge-danger">' . $this->toLabel() . '</span>',
        };
    }
}
