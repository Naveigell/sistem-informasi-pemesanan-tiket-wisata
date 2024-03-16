@extends('layouts.customer.customer')

@section('content-body')
    <hr>
    <div class="inner container">
        <h1>History Pemesanan</h1>
        @if ($message = session()->get('success'))
            <x-alert.success :message="$message" :dismissable="true"></x-alert.success>
        @endif
        <div class="row mb-5">
            @foreach($transactions as $transaction)
                <div class="col-4 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Transaksi - {{ $loop->iteration }}</h4>
                            @if($transaction->latestPayment)
                                Status Pembayaran :  {!! $transaction->latestPayment->payment_status->toHtmlBadge() !!}
                            @else
                                Status Pembayaran :  Belum ada pembayaran
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Pemesan</label>
                                <input type="text" disabled class="form-control" value="{{ $transaction->customer_name }}">
                            </div>
                            <div class="form-group">
                                <label>Email Pemesan</label>
                                <input type="text" disabled class="form-control" value="{{ $transaction->customer_email }}">
                            </div>
                            <div class="form-group">
                                <label>No Telp Pemesan</label>
                                <input type="text" disabled class="form-control" value="{{ $transaction->customer_phone }}">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Booking</label>
                                <input type="text" disabled class="form-control" value="{{ $transaction->booking_date->format('d F Y') }}">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Tiket</label>
                                <input type="number" disabled class="form-control" value="{{ $transaction->number_of_tickets }}" step="1" min="0">
                            </div>
                            <div class="form-group">
                                <a href="{{ route('customer.transactions.edit', $transaction) }}" class="btn btn-primary">Lihat</a>
                                @if($transaction->latestPayment && $transaction->latestPayment->payment_status->isValid())
                                    <a href="{{ route('guest.transactions.show', $transaction) }}" class="btn btn-success">Lihat Tiket</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
