@extends('layouts.customer.customer')

@section('content-body')
    <div class="main">
        <x-carousel></x-carousel>

        <br>
        <br>
        <div class="inner">
            <h1>Pesan Tiket Secara Online</h1>
            @if(!optional(auth()->user())->isCustomer())
                <h3>Tiket dapat dipesan dengan login ataupun tidak, mohon untuk membaca tata cara dibawah.</h3>
                <div>
                    Tata cara memesan tiket :
                    <ol class="pb-0 mb-0">
                        <li>Dengan login</li>
                    </ol>
                    <ul class="ml-4 pb-1 mb-1">
                        <li>Pengunjung diharapkan login dengan cara menekan menu di pojok kanan atas lalu memilih login</li>
                        <li>Setelah berhasil login, pengunjung dapat melakukan pembelian tiket melalui halaman ini</li>
                        <li>Setelah memilih tiket, pengunjung wajib untuk mengupload bukti pembarayaran untuk kemudian disetujui oleh admin</li>
                        <li>Setelah disetujui oleh admin, pengunjung dapat menunjukkan tiketnya kepada petugas di tempat</li>
                        <li>Kelebihan dari pembelian tiket dengan login terlebih dahulu adalah pengunjung dapat melihat history dari pembeliannya</li>
                        <li>Wisatawan <b>domestik</b> wajib mencantumkan <b>nik</b> saat membeli tiket</li>
                    </ul>
                    <ol class="pb-0 mb-0" start="2">
                        <li>Tanpa login</li>
                    </ol>
                    <ul class="ml-4 pb-1 mb-1">
                        <li>Pengunjung dapat melakukan pembelian tiket dengan mengisi form pada form di bawah ini</li>
                        <li>Setelah mengisi formuli, pengunjung akan mendapatkan email yang berisi link untuk mengupload bukti pembayaran</li>
                        <li>Setelah bukti pembayaran berhasil di upload dan admin menyetujui pembayaran, pengunjung akan menerima tiket dan qr code melalui email</li>
                        <li>Tunjukkan tiket tersebut kepada petugas di tempat</li>
                        <li>Wisatawan <b>domestik</b> wajib mencantumkan <b>nik</b> saat membeli tiket</li>
                    </ul>
                </div>
            @endif
            <form action="{{ route('tickets.store') }}" class="d-block" method="post">
                @csrf
                <div class="mt-5 pt-5">
                    <h2>Form Pemesanan Tiket</h2>
                    @if ($message = session()->get('success'))
                        <x-alert.success :message="$message" :dismissable="true"></x-alert.success>
                    @endif
                    <div>
                        @if(!optional(auth()->user())->isCustomer())
                            <div class="form-group">
                                <label for="customer_name">Nama</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                @error('customer_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_email">Email</label>
                                <input type="text" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                @error('customer_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_phone">No Telepon</label>
                                <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone') }}" id="customer_phone" name="customer_phone">
                                @error('customer_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="booking_date">Tanggal Pesan</label>
                            <input type="date" class="form-control @error('booking_date') is-invalid @enderror" value="{{ old('booking_date') }}" id="booking_date" name="booking_date">
                            @error('booking_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="booking_date">Nik</label>
                            <input type="text" class="form-control @error('identity_number') is-invalid @enderror" value="{{ old('identity_number') }}" id="identity_number" name="identity_number">
                            <small class="text-muted text-small">* Wisatawan domestik wajib memasukkan nik</small>
                            @error('identity_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-4 pt-4">
                            <h3>Pilih Tiket</h3>
                        </div>
                        <div class="row">
                            @foreach($tickets as $ticket)
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Tiket - {{ $ticket->name }}</h4>
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
                                                <label>Jumlah Tiket</label>
                                                <input type="number" class="form-control @error('tickets.' . $ticket->id) is-invalid @enderror" name="tickets[{{ $ticket->id }}]" value="{{ old('tickets.' . $ticket->id, 0) }}" step="1" min="0">
                                                @error('tickets.' . $ticket->id)
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($errors->has('total_tickets'))
                                <div class="mt-3">
                                    <input type="hidden" class="form-control is-invalid">
                                    <div class="invalid-feedback">
                                        <h3>{{ $errors->first('total_tickets') }}</h3>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Pesan Tiket</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
