<?php

namespace App\Interfaces;

interface HasQrCode
{
    /**
     * Generates a QR code.
     */
    public function generateQrCode();
}
