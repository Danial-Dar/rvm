<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->email = 'superadmin@gmail.com';
        $user->password = bcrypt('admin123');
        $user->role = 'admin';
        $user->status = '1';
        $user->save();

        $user = new User;
        $user->first_name = 'Test';
        $user->last_name = 'User';
        $user->email = 'user@gmail.com';
        $user->password = bcrypt('user123');
        $user->role = 'user';
        $user->status = '1';
        $user->save();
    }
}
