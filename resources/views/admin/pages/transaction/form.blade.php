@extends('layouts.admin.admin')

@section('content-title', 'Transaksi Pemesanan')

@section('content-body')
    <div class="row">
        <div class="col-lg-7 col-md-7 col-7 col-sm-12 no-padding-margin">
            <div class="card">
                <div class="card-header">
                    <h4>Pemesanan</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nik Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->identity_number : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->customer_name : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Email Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->customer_email : '' }}">
                    </div>
                    <div class="form-group">
                        <label>No Telp Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->customer_phone : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Qr Code</label>
                        <div>
                            <a href="{{ $transaction->qr_code_image_url }}" class="image-zoom">
                                <img src="{{ $transaction->qr_code_image_url }}" alt="" style="width: 250px; height: 250px;">
                            </a>
                        </div>
                        <small class="text text-muted mt-2 d-block">* Digunakan oleh customer jika ingin scan transaksinya (click untuk memperbesar)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <h4>Pembayaran Terakhir</h4>
                </div>
                <div class="card-body">
                    @if(!$transaction->latestPayment)
                        <x-alert.danger message="Belum ada pembayaran" :dismissable="false"></x-alert.danger>
                    @else
                        @if ($message = session()->get('payment-success'))
                            <x-alert.success :message="$message"></x-alert.success>
                        @endif
                        <form action="{{ route('admin.transactions.payments.update', [$transaction, $transaction->latestPayment]) }}" class="" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Tipe Pembayaran</label>
                                <input type="text" disabled class="form-control" value="{{ @$transaction ? optional($transaction->latestPayment)->payment_method->toLabel() : '' }}">
                            </div>
                            <div class="form-group">
                                <label>Bukti Pembayaran</label>
                                <div>
                                    <a href="{{ $transaction->latestPayment->payment_proof_image_url }}" class="image-zoom">
                                        <img src="{{ $transaction->latestPayment->payment_proof_image_url }}" alt="" style="width: 250px; height: 250px;">
                                    </a>
                                </div>
                                <small class="text text-muted mt-2 d-block">* Klik untuk memperbesar</small>
                            </div>
                            <div class="form-group">
                                <label>Status Pembayaran</label>
                                <select name="payment_status" id="" class="form-control @error('payment_status') is-invalid @enderror">
                                    <x-nothing-selected></x-nothing-selected>
                                    @foreach(\App\Enums\PaymentStatusEnum::cases() as $case)
                                        <option value="{{ $case->value }}" {{ old('payment_status', @$transaction ? optional($transaction->latestPayment)->payment_status->value : '') == $case->value ? 'selected' : '' }}>{{ $case->toLabel() }}</option>
                                    @endforeach
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($transaction->transactionTickets as $ticket)
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Tiket - {{ $loop->iteration }}</h4>
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
                        <div class="form-group">
                            <label>Qr Code</label>
                            <div>
                                <a href="{{ $ticket->qr_code_image_url }}" class="image-zoom">
                                    <img src="{{ $ticket->qr_code_image_url }}" alt="" style="width: 250px; height: 250px;">
                                </a>
                            </div>
                            <small class="text text-muted mt-2 d-block">* Klik untuk memperbesar</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
