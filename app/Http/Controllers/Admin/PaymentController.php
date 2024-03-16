<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentRequest;
use App\Jobs\SendGuestFailedPaymentJob;
use App\Jobs\SendGuestSuccessPaymentJob;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $request, Transaction $transaction, Payment $payment)
    {
        abort_if($transaction->id != $payment->transaction_id, 404);

        $payment->update($request->validated());

        // if transaction is not belongs to any customer, we send email
        // if it's for logged user (customer)
        if ($transaction->isNotBelongsToAnyCustomer()) {
            // send email after payment valid or not valid
            if ($payment->payment_status->isValid()) {
                dispatch(new SendGuestSuccessPaymentJob($transaction));
            } elseif ($payment->payment_status->isNotValid()) {
                dispatch(new SendGuestFailedPaymentJob($transaction));
            }
        }

        return redirect(route('admin.transactions.edit', $transaction))->with('payment-success', 'Payment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
