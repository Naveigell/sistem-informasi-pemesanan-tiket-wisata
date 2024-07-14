@extends('layouts.customer.customer')

@section('content-body')
    <hr>
    <div class="main">
        <div class="inner">
            <h1>Form Pembayaran</h1>
            @if ($message = session()->get('success'))
                <x-alert.success :message="$message" :dismissable="true"></x-alert.success>
            @endif
            <form action="{{ route('guest.payments.store') . '?' . $transaction->buildTokenQueryString() }}"
                  class="d-block" method="post" enctype="multipart/form-data">
                @csrf
                <h6>Anda dapat melakukan pembayaran tiket melalui form berikut.</h6>
                <div class="card">
                    <div class="card-body">
                        <p>Detail transaksi:</p>
                        <table class="table">
                            <tr>
                                <td class="col-2">Nik</td>
                                <td class="col-1">:</td>
                                <td>{{ $transaction->identity_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-2">Nama</td>
                                <td class="col-1">:</td>
                                <td>{{ $transaction->customer_name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $transaction->customer_email }}</td>
                            </tr>
                            <tr>
                                <td>No Telp</td>
                                <td>:</td>
                                <td>{{ $transaction->customer_phone }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pemesanan</td>
                                <td>:</td>
                                <td>{{ $transaction->booking_date->format("d F Y") }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Tiket</td>
                                <td>:</td>
                                <td>{{ $transaction->number_of_tickets }}</td>
                            </tr>
                            <tr>
                                <td>Total Harga</td>
                                <td>:</td>
                                <td>
                                    {{ format_price($transaction->transactionTickets->sum(fn($ticket) => $ticket->price * $ticket->quantity)) }}
                                    &nbsp;
                                    <button data-toggle="modal" data-target="#modal-ticket" type="button" class="btn btn-primary btn-sm">Lihat Tiket</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Upload Bukti Pembayaran</td>
                                <td>:</td>
                                <td><input type="file" class="form-control" name="payment" accept="image/*"></td>
                            </tr>
                        </table>
                        <p class="mb-3">
                            <small class="text text-muted">* Catatan : Mohon diingat jika pembayaran tidak valid, maka
                                anda akan menerima email kembali.</small>
                        </p>

                        <div class="row">
                            <div class="col-5">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="text text-muted text-small" style="font-size: 16px;">
                                            <span>Mohon untuk mengirim pembayaran melalui rekening berikut</span>
                                            <ul>
                                                @foreach(config('information.account_numbers') as $account)
                                                    <li>{{ $account['account'] }} &nbsp;&nbsp;&nbsp;[{{ $account['name'] }}] - ({{ $account['bank'] }})</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <x-modal.base id="modal-ticket" title="List Tiket">
        <x-slot:body>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tiket</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->transactionTickets as $ticket)
                        <tr>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ format_price($ticket->price) }}</td>
                            <td>x{{ $ticket->quantity }}</td>
                            <td>{{ format_price($ticket->price * $ticket->quantity) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Total Harga</td>
                        <td>{{ format_price($transaction->transactionTickets->sum(fn($ticket) => $ticket->price * $ticket->quantity)) }}</td>
                    </tr>
                </tbody>
            </table>
        </x-slot:body>
        <x-slot:customModalFooter>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </x-slot:customModalFooter>
    </x-modal.base>
@endsection
