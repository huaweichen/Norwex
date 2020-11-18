<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(200)->completed()->withInMonth(['month' => 3])->create();
        Order::factory(500)->completed()->withInMonth(['month' => 12])->create();
        Order::factory(1000)->completed()->withInMonth(['month' => 24])->create();
        Order::factory(20)->incomplete()->create();
    }
}
