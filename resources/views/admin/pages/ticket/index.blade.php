@extends('layouts.admin.admin')

@section('content-title', 'Tiket')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Tiket</h4>
                @if(auth()->user()->isAdmin())
                    <div class="card-header-action">
                        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Tiket</a>
                    </div>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive mb-3">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-1">Nama</th>
                            <th class="col-1">Harga</th>
                            <th class="col-2">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$tickets" :loop="$loop"></x-iterate>
                                </td>
                                <td class="py-3">{{ $ticket->name }}</td>
                                <td>{{ format_price($ticket->price) }}</td>
                                <td>
                                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger btn-action trigger--modal-delete cursor-pointer" data-url="{{ route('admin.tickets.destroy', $ticket) }}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-modal')
    <x-modal.delete :name="'Tiket'"></x-modal.delete>
@endsection
