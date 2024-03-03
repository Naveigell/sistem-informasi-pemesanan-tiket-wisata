@extends('layouts.admin.admin')

@section('content-title', 'Tiket')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <div class="card">
            <form action="{{ @$ticket ? route('admin.tickets.update', $ticket) : route('admin.tickets.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method(@$ticket ? 'PUT' : 'POST')
                <div class="card-header">
                    <h4>Form Tiket</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Tiket</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', @$ticket ? $ticket->name : '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Kode Tiket</label>
                        <input type="text" class="form-control @error('ticket_code') is-invalid @enderror" name="ticket_code" value="{{ old('ticket_code', @$ticket ? $ticket->ticket_code : '') }}">
                        @error('ticket_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tipe Tiket</label>
                        <select name="group" id="" class="form-control @error('group') is-invalid @enderror">
                            <x-nothing-selected></x-nothing-selected>
                            @foreach(\App\Enums\TicketGroupEnum::cases() as $enum)
                                <option value="{{ $enum->value }}" {{ old('group', @$ticket ? $ticket->group->value : '') == $enum->value ? 'selected' : '' }}>{{ $enum->toLabel() }}</option>
                            @endforeach
                        </select>
                        @error('group')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control price @error('price') is-invalid @enderror" name="price" value="{{ old('price', @$ticket ? round($ticket->price) : '') }}">
                        @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection