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

            $data = $request->validated();

            // if customer is logged in, we got the customer data from it's bio data
            if (optional(auth()->user())->isCustomer()) {

                /**
                 * @var \App\Models\User $user
                 * @var \App\Models\Customer $userable
                 */
                $user = auth()->user();
                $userable = $user->userable;

                $data = array_merge($data, [
                    "user_id" => $user->id,
                    "customer_name" => $user->name,
                    "customer_email" => $user->email,
                    "customer_phone" => $userable->phone,
                ]);
            }

            $transaction = new Transaction($data);
            $transaction->generateUuid();
            $transaction->generateQrCode();
            $transaction->setNumberOfTicketAttribute($request->getTotalTickets());
            $transaction->save();

            // looping every tickets that user want to order and save every ticket into transaction
            foreach ($tickets as $ticket) {
                $transactionTicket = new TransactionTicket($ticket->toArray());
                $transactionTicket->generateUuid();
                $transactionTicket->generateQrCode();
                $transactionTicket->setQuantityAttribute($request->getTotalTicketById($ticket->id));
                $transactionTicket->transaction()->associate($transaction);
                $transactionTicket->save();
            }

            DB::commit();

            // send payment email after creating transaction
            $transaction->sendEmail();
        } catch (\Exception $e) {
            DB::rollBack();

            dd($e->getMessage());
        }

        if (!optional(auth()->user())->isCustomer()) {
            return redirect(route('tickets.index'))->with('success', 'Berhasil memesan tiket, mohon untuk mengecek email anda untuk melanjutkan pembayaran');
        }

        return redirect(route('tickets.index'))->with('success', 'Berhasil memesan tiket, mohon untuk melihat dashboard untuk melanjutkan pemesanan');
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
