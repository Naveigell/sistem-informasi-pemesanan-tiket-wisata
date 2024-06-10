<?php

namespace Database\Seeders;

use App\Enums\TicketGroupEnum;
use App\Models\Ticket;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker  = Factory::create('id_ID');

        $tickets = [
            [
                "name" => "Domestic",
                "price" => 50_000
            ],
            [
                "name" => "Wisatawan",
                "price" => 75_000
            ]
        ];

        foreach ($tickets as $ticket) {
            Ticket::create([
                "name"  => $ticket['name'],
                "price" => $ticket['price'],
            ]);
        }
    }
}
