<?php

namespace Database\Seeders;

use App\Models\Permissions;
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
            ['name' => 'view','group_permission_id' => 1,'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'create','group_permission_id' => 1,'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'edit','group_permission_id' => 1,'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'delete','group_permission_id' => 1,'created_at' => now(),
                'updated_at' => now()]
        ]);
    }
}
