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

    /**
     * Check if the current instance is a transaction.
     *
     * @return bool
     */
    public function isTransaction()
    {
        return $this === self::TRANSACTION;
    }

    /**
     * Check if the current object is a transaction ticket
     *
     * @return bool
     */
    public function isTransactionTicket()
    {
        return $this === self::TRANSACTION_TICKET;
    }
}
