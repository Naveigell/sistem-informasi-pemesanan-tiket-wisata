<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QrCodeUrlTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidateQrCodeController extends Controller
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
        $model = $this->transaction($request);

        if ($model instanceof Transaction) {
            return view('admin.pages.validate.transaction', compact('model'));
        }

        return view('admin.pages.validate.ticket', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // only accept 'success' and 'failed'
        abort_if(!in_array($request->query('status'), TransactionStatusEnum::allValuesWithoutPending()), 404);

        $model = $this->transaction($request);

        if ($model instanceof Transaction) {
            DB::beginTransaction();

            try {
                // update the transaction status
                // and every transaction ticket
                $model->update(['transaction_status' => $request->query('status')]);
                $model->transactionTickets->each(function (TransactionTicket $ticket) use ($request) {
                    $ticket->update(['status' => $request->query('status')]);
                });

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        } else {
            // only update one ticket if the type is transaction ticket
            $model->update(['status' => $request->query('status')]);
        }

        return redirect(route('admin.validate.qr.create') . '?' . $model->buildTokenQueryString());
    }

    /**
     * Handle the transaction request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Transaction|\App\Models\TransactionTicket
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

        $modelType = QrCodeUrlTypeEnum::tryFrom($type);

        // Check if the specified type is valid
        abort_if($modelType == null, 404);

        // check if type from parameter is transaction or transaction ticket
        if ($modelType->isTransaction()) {
            $model = Transaction::where('transaction_code', $code)->firstOrFail();
        } else {
            $model = TransactionTicket::where('transaction_code', $code)->firstOrFail();
        }

        // Validate the token for the transaction and check if the transaction id is same as the route parameter
        abort_if(!$model->validateToken($token), 404);

        if ($model instanceof Transaction) {
            // Load the transaction tickets for the transaction if the model is transaction
            $model->load('transactionTickets');
        }

        // Return the transaction
        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
