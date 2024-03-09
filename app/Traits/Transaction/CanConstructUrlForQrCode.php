<?php

namespace App\Traits\Transaction;


/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 * @mixin \App\Models\Transaction
 * @mixin \App\Models\TransactionTicket
 */
trait CanConstructUrlForQrCode
{
    /**
     * Construct the URL for validating a QR code.
     *
     * @return string The constructed URL
     */
    public function constructUrl()
    {
        // Generate token
        $token = sha1(config('app.key') . $this->transaction_code . strtotime($this->transaction_date) . $this->getCalledClass());

        // Generate URL with token, code, and date parameters
        return route('admin.validate-qr', [
            "token"     => $token,
            "code"      => $this->transaction_code,
            "timestamp" => strtotime($this->transaction_date),
            "type"      => $this->getCalledClass(),
        ]);
    }
}
