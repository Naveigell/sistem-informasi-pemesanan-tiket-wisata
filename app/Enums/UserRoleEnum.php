<?php

namespace App\Enums;

use App\Enums\Interfaces\HasLabel;
use App\Models\Admin;
use App\Models\Customer;

enum UserRoleEnum: string
{
    case CUSTOMER = 'customer';

    case ADMIN = 'admin';

    /**
     * Get the value of the role
     *
     * @return string|void
     */
    public function model()
    {
        if ($this->value == self::ADMIN->value) {
            return Admin::class;
        }

        if ($this->value == self::CUSTOMER->value) {
            return Customer::class;
        }
    }
}
