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
        return route('guest.payments.create') . '?' . $this->httpQueryString();
    }

    /**
     * Construct the URL for the guest ticket page.
     *
     * @return string The constructed URL
     */
    public function constructGuestTicketPageUrl()
    {
        return route('guest.transactions.show', $this->id) . '?' . $this->httpQueryString();
    }

    /**
     * Generates a query string for HTTP request.
     *
     * @return string The generated query string
     */
    public function httpQueryString()
    {
        // Generate token
        $token = $this->createToken();

        // Build query parameters
        return http_build_query([
            "token"     => $token,
            "code"      => $this->transaction_code,
            "timestamp" => strtotime($this->booking_date),
            "type"      => strtolower($this->getClassShortName()),
        ]);
    }

    /**
     * Create a unique token based on app key, transaction code, booking date, and class short name
     *
     * @return string
     */
    private function createToken()
    {
        // Combine the app key, transaction code, booking date timestamp, and class short name to generate the token
        return sha1(config('app.key') . $this->transaction_code . strtotime($this->booking_date) . $this->getClassShortName());
    }

    /**
     * Check if the provided token matches the generated token
     *
     * @param string $token
     * @return bool
     */
    public function validateToken($token)
    {
        // Check if the generated token matches the provided token
        return $token === $this->createToken();
    }
}
