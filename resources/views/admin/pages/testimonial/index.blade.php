@extends('layouts.admin.admin')

@section('content-title', 'Testimoni')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Testimoni</h4>
                @if(auth()->user()->isAdmin())
                    <div class="card-header-action">
                        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Testimoni</a>
                    </div>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive mb-3">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th class="col-1">Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($testimonials as $testimonial)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$testimonials" :loop="$loop"></x-iterate>
                                </td>
                                <td class="py-3">{{ $testimonial->name }}</td>
                                <td>{{ $testimonial->description }}</td>
                                <td>
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger btn-action trigger--modal-delete cursor-pointer" data-url="{{ route('admin.testimonials.destroy', $testimonial) }}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $testimonials->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-modal')
    <x-modal.delete :name="'Testimonial'"></x-modal.delete>
@endsection
