<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_permissions')->insert([
            ['name' => 'Posts', 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'Users', 'created_at' => now(),
                'updated_at' => now()],
        ]);
    }
}
