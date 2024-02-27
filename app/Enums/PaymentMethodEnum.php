<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CASH = 'CASH';
    case CREDIT_CARD = 'CREDIT_CARD';
    case BANK_TRANSFER = 'BANK_TRANSFER';
}
