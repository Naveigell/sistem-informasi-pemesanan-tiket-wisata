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
        $groups = TicketGroupEnum::cases();

        foreach ($groups as $group) {
            Ticket::create([
                "name"        => $faker->streetName,
                "ticket_code" => strtoupper(substr(uniqid(), -5)),
                "group"       => $group->value,
                "price"       => rand(2, 5) * (10 ** rand(4, 5)),
            ]);
        }
    }
}
