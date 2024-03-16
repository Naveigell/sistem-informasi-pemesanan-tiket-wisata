<?php

namespace App\Http\Controllers\Guest;

use App\Enums\QrCodeUrlTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
    public function show(Request $request, Transaction $transaction)
    {
        $transaction = $this->transaction($request, $transaction);
        $transaction->load('transactionTickets');

        return view('guest.pages.transaction.show', compact('transaction'));
    }

    /**
     * Handle the transaction request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \App\Models\Transaction
     */
    private function transaction(Request $request, Transaction $transaction)
    {
        // Check if the transaction belongs to the user and user has logged in
        // if customer has logged in, we don't need to check by its query string
        if (optional(auth()->user())->isCustomer() && $transaction->isBelongsToUser(auth()->user())) {
            $transaction->load('transactionTickets');

            return $transaction;
        }

        // Check if all required parameters are present
        abort_if(!$request->has('token', 'code', 'timestamp', 'type'), 404);

        // Retrieve parameters from the request
        $token     = $request->query('token');
        $code      = $request->query('code');
        $timestamp = $request->query('timestamp');
        $type      = $request->query('type');

        // Check if the specified type is valid
        abort_if(QrCodeUrlTypeEnum::tryFrom($type) == null, 404);

        // Validate the token for the transaction and check if the transaction id is same as the route parameter
        abort_if(!$transaction->validateToken($token) || $transaction->id != $request->route('transaction'), 404);

        // Load the transaction tickets for the transaction
        $transaction->load('transactionTickets');

        // Return the transaction
        return $transaction;
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
}
