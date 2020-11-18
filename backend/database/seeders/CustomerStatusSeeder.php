<?php

namespace Database\Seeders;

use App\Models\CustomerStatus;
use Illuminate\Database\Seeder;

class CustomerStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerStatus::updateOrCreate([
            'code' => CustomerStatus::ACTIVE,
            'name' => 'Active'
        ]);

        CustomerStatus::updateOrCreate([
            'code' => CustomerStatus::REMOVED,
            'name' => 'Removed'
        ]);
    }
}
