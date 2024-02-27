<?php

namespace App\Enums\Interfaces;

interface HasLabel
{
    /**
     * Returns the label for this enum.
     */
    public function toLabel(): string;
}
