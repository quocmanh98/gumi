<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['name' => 'viewAny', 'group_permission_id' => 1, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'view', 'group_permission_id' => 1, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'create', 'group_permission_id' => 1, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'update', 'group_permission_id' => 1, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'delete', 'group_permission_id' => 1, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'restore', 'group_permission_id' => 1, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'forceDelete', 'group_permission_id' => 1, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'viewAny', 'group_permission_id' => 2, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'view', 'group_permission_id' => 2, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'create', 'group_permission_id' => 2, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'update', 'group_permission_id' => 2, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'delete', 'group_permission_id' => 2, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'restore', 'group_permission_id' => 2, 'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'forceDelete', 'group_permission_id' => 2, 'created_at' => now(),
                'updated_at' => now()],
        ]);
    }
}
