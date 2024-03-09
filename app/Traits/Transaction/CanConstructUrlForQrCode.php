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
    public function constructValidateQrCodeUrl()
    {
        // Generate URL with token, code, and date parameters
        return route('admin.validate-qr') . '?' . $this->httpQueryString();
    }

    /**
     * Construct the guest payment URL.
     *
     * @return string
     */
    public function constructGuestPaymentUrl()
    {
        // Generate the guest payment URL with HTTP query string
        return route('guest.pay') . '?' . $this->httpQueryString();
    }

    /**
     * Generates a query string for HTTP request.
     *
     * @return string The generated query string
     */
    private function httpQueryString()
    {
        // Generate token
        $token = sha1(config('app.key') . $this->transaction_code . strtotime($this->booking_date) . $this->getClassShortName());

        // Build query parameters
        return http_build_query([
            "token"     => $token,
            "code"      => $this->transaction_code,
            "timestamp" => strtotime($this->booking_date),
            "type"      => strtolower($this->getClassShortName()),
        ]);
    }
}
