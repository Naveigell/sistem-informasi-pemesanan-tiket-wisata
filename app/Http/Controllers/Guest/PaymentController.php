<?php

namespace App\Http\Controllers\Guest;

use App\Enums\PaymentMethodEnum;
use App\Enums\QrCodeUrlTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\PaymentRequest;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $transaction = $this->transaction($request);

        return view('guest.pages.payment.form', compact('transaction'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        $transaction = $this->transaction($request);

        DB::beginTransaction();

        try {
            $payment = new Payment(["payment_method" => PaymentMethodEnum::BANK_TRANSFER->value]);
            $payment->saveFile('payment_proof_image', $request->file('payment'), $payment->fullPath());
            $payment->transaction()->associate($transaction);
            $payment->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect(route('guest.payments.create') . '?' . $transaction->buildTokenQueryString())->with('success', 'Pembayaran berhasil, mohon untuk menunggu notifikasi pembayaran');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Transaction
     */
    private function transaction(Request $request)
    {
        // Check if all required parameters are present
        abort_if(!$request->has('token', 'code', 'timestamp', 'type'), 404);

        // Retrieve parameters from the request
        $token     = $request->query('token');
        $code      = $request->query('code');
        $timestamp = $request->query('timestamp');
        $type      = $request->query('type');

        // Check if the specified type is valid
        abort_if(QrCodeUrlTypeEnum::tryFrom($type) == null, 404);

        // Find the transaction with the specified code
        $transaction = Transaction::where('transaction_code', $code)->firstOrFail();

        // Validate the token for the transaction
        abort_if(!$transaction->validateToken($token), 404);

        // Load the transaction tickets for the transaction
        $transaction->load('transactionTickets');

        // Return the transaction
        return $transaction;
    }
}
