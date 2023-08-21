<?php

namespace Database\Seeders;

use App\Models\SmsBilling;
use Illuminate\Database\Seeder;

class SmsBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmsBilling::factory()
            ->count(3000)
            ->create();
    }
}
