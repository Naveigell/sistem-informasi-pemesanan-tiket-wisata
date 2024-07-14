@extends('layouts.customer.customer')

@section('content-body')
    <hr>
    <div class="main">
        <div class="inner">
            <h1>Detail Transaksi</h1>
            @if ($message = session()->get('success'))
                <x-alert.success :message="$message" :dismissable="true"></x-alert.success>
            @endif
            <form action="{{ route('customer.transactions.update', $transaction) }}"
                  class="d-block" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h6>Anda dapat melakukan pembayaran tiket melalui form berikut.</h6>
                <div class="card">
                    <div class="card-body">
                        <p>Status Validasi Tiket : {!! $transaction->transaction_status->toHtmlBadge() !!}</p>
                        <p>Detail transaksi:</p>
                        <table class="table">
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
                                <td>{{ $transaction->booking_date->format('d F Y') }}</td>
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
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="text text-muted text-small" style="font-size: 16px;">
                                        <span>Mohon untuk mengirim pembayaran melalui rekening berikut</span>
                                        <ul>
                                            @foreach(config('information.account_numbers') as $account)
                                                <li>{{ $account['account'] }} &nbsp;&nbsp;&nbsp;[{{ $account['name'] }}] - ({{ $account['bank'] }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <button class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>

            <div class="row">
                @foreach($transaction->transactionTickets as $ticket)
                    <div class="col-4 mt-4 pt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tiket - {{ $loop->iteration }}</h4>
                                <span>{!! $ticket->status->toHtmlBadge() !!}</span>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Tiket</label>
                                    <input type="text" disabled class="form-control" value="{{ $ticket->name }}">
                                </div>
                                <div class="form-group">
                                    <label>Harga Tiket</label>
                                    <input type="text" disabled class="form-control" value="{{ format_price($ticket->price) }}">
                                </div>
                                @if($transaction->transaction_status->isSuccess())
                                    <div class="form-group">
                                        <label>Qr Code</label>
                                        <div>
                                            <a href="{{ $ticket->qr_code_image_url }}" class="image-zoom">
                                                <img src="{{ $ticket->qr_code_image_url }}" alt="" style="width: 250px; height: 250px;">
                                            </a>
                                        </div>
                                        <small class="text text-muted mt-2 d-block">* Klik untuk memperbesar</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
            </div>
            <br>
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
