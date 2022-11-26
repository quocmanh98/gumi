<?php

namespace Database\Seeders;

use App\Models\BookType;
use App\Models\bookTypes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookType::insert([
            ['name' => 'Chính trị','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['name' => 'Pháp luật','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['name' => 'Khoa học công nghệ','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['name' => 'Kinh tế','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['name' => 'Doremon','created_at' => Carbon::now(),'updated_at' => Carbon::now()]
        ]);
    }
}
