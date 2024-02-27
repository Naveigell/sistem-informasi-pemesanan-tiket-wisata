<?php

namespace App\Enums;

enum TransactionStatusEnum: string
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
}
