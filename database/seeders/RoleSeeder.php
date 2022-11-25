<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Super Admin', 'created_at' => now(),
            'updated_at' => now()],
            ['name' => 'Admin', 'created_at' => now(),
            'updated_at' => now()],
            ['name' => 'User', 'created_at' => now(),
            'updated_at' => now()]
        ]);
    }
}
