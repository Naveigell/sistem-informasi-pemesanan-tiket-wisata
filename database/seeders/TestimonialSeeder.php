<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                "name" => "Andini",
                "description" => "Mencari tempat rekreasi yang cocok untuk semua anggota keluarga memanglah tidak mudah. Tapi, saya baru saja menemukan tempat yang sempurna!"
            ],
            [
                "name" => "Son",
                "description" => "Staf di tempat ini sangat ramah dan membantu. Mereka selalu siap menjawab pertanyaan dan memberikan informasi tentang tempat rekreasi. Suasana di sini juga sangat bersih dan nyaman. Tersedia banyak tempat duduk dan toilet yang bersih. Secara keseluruhan, saya sangat puas dengan pengalaman saya di Wanagiri Heaven. Tempat ini sangat cocok untuk keluarga yang ingin menghabiskan waktu bersama dengan menyenangkan."
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
