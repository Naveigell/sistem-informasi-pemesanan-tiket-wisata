@extends('layouts.customer.customer')

@push('content-style')
    <style>

    </style>
@endpush

@section('content-body')
    <hr>
    <h1 class="text-center">Galeri</h1>
    <div class="col-12 row text-center container">
        @foreach($galleries as $gallery)
            <div class="col-3 mt-3">
                <a href="{{ $gallery->image_url }}" class="image-zoom" style="border: none;">
                    <img src="{{ $gallery->image_url ?? 'https://placehold.co/600x400' }}" alt="" class="img-thumbnail">
                </a>
            </div>
        @endforeach
    </div>
@endsection



