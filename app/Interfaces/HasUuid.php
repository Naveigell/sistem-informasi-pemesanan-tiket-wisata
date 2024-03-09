<?php

namespace App\Interfaces;

interface HasUuid
{
    /**
     * Generate a new UUID.
     *
     * @return void
     */
    public function generateUuid();
}
