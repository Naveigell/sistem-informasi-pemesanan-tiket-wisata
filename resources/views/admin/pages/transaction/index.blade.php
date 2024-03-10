@extends('layouts.admin.admin')

@section('content-title', 'Transaksi Pemesanan')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Transaksi</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive mb-3">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-1">Nama Kustomer</th>
                            <th class="col-1">Email Kustomer</th>
                            <th class="col-1">No Telp Kustomer</th>
                            <th class="col-1">Pembayaran Terakhir</th>
                            <th class="col-1">Status Transaksi</th>
                            <th class="col-2">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$transactions" :loop="$loop"></x-iterate>
                                </td>
                                <td class="py-3">{{ $transaction->customer_name }}</td>
                                <td>{{ $transaction->customer_email }}</td>
                                <td>{{ $transaction->customer_phone }}</td>
                                <td class="py-3">
                                    @if ($transaction->latestPayment)
                                        <a href="{{ $transaction->latestPayment->payment_proof_image_url }}" class="image-zoom">
                                            <img src="{{ $transaction->latestPayment->payment_proof_image_url }}" alt="" style="width: 150px; height: 150px;">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{!! $transaction->transaction_status->toHtmlBadge() !!}</td>
                                <td>
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger btn-action trigger--modal-delete cursor-pointer" data-url="{{ route('admin.transactions.destroy', $transaction) }}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-modal')
    <x-modal.delete :name="'Transaksi'"></x-modal.delete>
@endsection
