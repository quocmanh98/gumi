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

        User::insert([
            [
                'username' => 'Quốc Mạnh',
                'email' => 'quocmanh1998s@gmail.com',
                'password' => bcrypt('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'role_id' => 1
            ],
            [
                'username' => 'Quốc Việt',
                'email' => 'quocviet2001s@gmail.com',
                'password' => bcrypt('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
                'role_id' => 3
            ],
        ]);
    }
}
