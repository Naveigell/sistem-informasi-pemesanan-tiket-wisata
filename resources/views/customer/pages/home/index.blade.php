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

            <h2 class="h2">Testimonials</h2>

            <div class="row">
                <div class="col-sm-6 text-center">
                    <p class="m-n"><em>"Mencari tempat rekreasi yang cocok untuk semua anggota keluarga memanglah tidak mudah. Tapi, saya baru saja menemukan tempat yang sempurna!"</em></p>

                    <p><strong> - Andini</strong></p>
                </div>

                <div class="col-sm-6 text-center">
                    <p class="m-n"><em>"Staf di tempat ini sangat ramah dan membantu. Mereka selalu siap menjawab pertanyaan dan memberikan informasi tentang tempat rekreasi.

                            Suasana di sini juga sangat bersih dan nyaman. Tersedia banyak tempat duduk dan toilet yang bersih.

                            Secara keseluruhan, saya sangat puas dengan pengalaman saya di Wanagiri Heaven. Tempat ini sangat cocok untuk keluarga yang ingin menghabiskan waktu bersama dengan menyenangkan."</em></p>

                    <p><strong>- Putra</strong> </p>
                </div>
            </div>

            <br>

        </div>
    </div>
@endSection
