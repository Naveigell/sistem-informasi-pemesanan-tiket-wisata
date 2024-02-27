<?php

namespace App\Enums;

use App\Enums\Interfaces\HasLabel;

enum TicketGroupEnum: string implements HasLabel
{
    case KID = 'kid';
    case ADULT = 'adult';
    case SENIOR = 'senior';

    /**
     * Returns the label for this enum.
     */
    public function toLabel(): string
    {
        return match ($this) {
            self::KID => 'Anak - anak',
            self::ADULT => 'Orang dewasa',
            self::SENIOR => 'Senior',
        } ;
    }
}
