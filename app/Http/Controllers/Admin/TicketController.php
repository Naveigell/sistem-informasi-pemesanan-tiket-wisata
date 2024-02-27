<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::paginate(10);

        return view('admin.pages.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.ticket.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        Ticket::create($request->validated());

        return redirect(route('admin.tickets.index'))->with('success', 'Berhasil menambahkan tiket');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        return view('admin.pages.ticket.form', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        return redirect(route('admin.tickets.index'))->with('success', 'Berhasil mengubah tiket');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect(route('admin.tickets.index'))->with('success', 'Berhasil menghapus tiket');
    }
}
