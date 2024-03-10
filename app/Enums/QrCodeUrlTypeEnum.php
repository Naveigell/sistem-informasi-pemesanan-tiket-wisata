<?php

namespace App\Enums;

use App\Enums\Interfaces\HasLabel;

enum QrCodeUrlTypeEnum: string implements HasLabel
{
    case TRANSACTION           = 'transaction';
    case TRANSACTION_TICKET    = 'transactionticket';


    /**
     * Returns the label for this enum.
     */
    public function toLabel(): string
    {
        return match ($this) {
            self::TRANSACTION => 'Transaction',
            self::TRANSACTION_TICKET => 'Transaction Ticket',
        };
    }
}
