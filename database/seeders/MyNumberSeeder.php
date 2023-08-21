<?php

namespace Database\Seeders;

use App\Models\MyNumber;
use Illuminate\Database\Seeder;

class MyNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $number = new MyNumber();
        $number->number = '17253341378';
        $number->status = '1';
        $number->user_id = 2;
        $number->save();
    }
}
