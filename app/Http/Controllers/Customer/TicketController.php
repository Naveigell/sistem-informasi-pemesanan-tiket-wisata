<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\TicketRequest;
use App\Mail\GuestOrderMail;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\TransactionTicket;
use App\Utils\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();

        return view('customer.pages.ticket.index', compact('tickets'));
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
    public function store(TicketRequest $request)
    {
        DB::beginTransaction();

        try {
            $tickets = Ticket::whereIn('id', $request->ticket_ids)->get();

            $transaction = new Transaction($request->validated());
            $transaction->generateUuid();
            $transaction->generateQrCode();
            $transaction->setNumberOfTicketAttribute($tickets->count());
            $transaction->save();

            // looping every tickets that user want to order and save every ticket into transaction
            foreach ($tickets as $ticket) {
                $transactionTicket = new TransactionTicket($ticket->toArray());
                $transactionTicket->generateUuid();
                $transactionTicket->generateQrCode();
                $transactionTicket->transaction()->associate($transaction);
                $transactionTicket->save();
            }

            DB::commit();

            // TODO: send payment email after creating transaction
            $transaction->sendEmail();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect(route('tickets.index'))->with('success', 'Berhasil memesan tiket, mohon untuk mengecek email anda untuk melanjutkan pembayaran');
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
