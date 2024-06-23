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

            <h2 class="h2 mt-5 pt-5 text-center">Testimonials</h2>

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

            <h2 class="h2 mt-5 pt-5 mb-5 text-center">Lokasi - <i class="fa fa-map-marker"></i></h2>

            <iframe style="width: 100%; height: 500px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d629.1001889967912!2d115.13624566952565!3d-8.23731505224863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd18f26b36b8abd%3A0x2d54e26d7664901d!2sWanagiri%20Heaven%20Selfie%20Pucak!5e0!3m2!1sid!2sid!4v1719146585400!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <br>

        </div>
    </div>
@endSection
