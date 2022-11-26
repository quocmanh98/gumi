<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permission')->insert([
            ['permission_id' => 1, 'role_id' => 1 ,'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 2, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 3, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()],
            ['permission_id' => 4, 'role_id' => 1, 'created_at' => now(),
            'updated_at' => now()]
        ]);
    }
}
