<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PaymentMethodEnum;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())->latest()->get();

        return view('customer.pages.transaction.index', compact('transactions'));
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
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        abort_if($transaction->user_id != auth()->id(), 404);

        $transaction->load('transactionTickets');

        return view('customer.pages.transaction.form', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
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

        return redirect(route('customer.transactions.index'))->with('success', 'Pembayaran berhasil, mohon untuk menunggu validasi dari admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
