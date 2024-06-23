@extends('layouts.customer.customer')

@push('content-style')
    <style>
        .carousel-item > img {
            width: 100%;
            /*height: 100%;*/
            /*object-fit: fill;*/
        }
    </style>
@endpush

@section('content-body')
    <!-- Main -->
    <div id="main">
        <x-carousel></x-carousel>

        <br>
        <br>

        <div class="inner">
            <!-- About Us -->
            <header id="inner">
                <h1>Tempat rekreasi terbaik segala usia</h1>
                <p>Mencari tempat rekreasi yang cocok untuk semua anggota keluarga bisa menjadi hal yang rumit. Setiap orang memiliki preferensi yang berbeda, mulai dari anak-anak yang ingin bermain dan berpetualang, hingga orang dewasa yang ingin bersantai dan menikmati suasana yang tenang.

                    Namun, jangan khawatir! Wanagiri Heaver adalah rekomendasi tempat rekreasi terbaik yang cocok untuk segala kalangan.</p>
            </header>

            <br>

            <h2 class="h2 mt-5 text-center">Testimonials</h2>

            <div id="carouselExampleControls" class="carousel slide mt-5 pt-5" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($testimonials as $chunks)
                        <div class="carousel-item @if($loop->first) active @endif text-center">
                            <div class="row">
                                @foreach($chunks as $testimonial)
                                    <div class="col-sm-6 text-center">
                                        <p class="m-n"><em>"{{ $testimonial->description }}"</em></p>

                                        <p><strong> - {{ $testimonial->name }}</strong></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev" style="border: none; left: -120px;">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="color: black; background-color: black;"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next" style="border: none; right: -120px;">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="color: black; background-color: black;"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <br>

        </div>
    </div>
@endSection
