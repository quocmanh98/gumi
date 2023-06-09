<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BookTypeSeeder::class,
            BookSeeder::class,
            PostSeeder::class,
            GroupPermissionSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class
        ]);
    }
}
