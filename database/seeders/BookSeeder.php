<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Books;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::insert([
            ['title' => 'Book 1','content' => 'Content 1','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 2','content' => 'Content 2','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 3','content' => 'Content 3','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 4','content' => 'Content 4','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 5','content' => 'Content 5','type_id' => 3,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 6','content' => 'Content 6','type_id' => 4,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 7','content' => 'Content 7','type_id' => 5,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 8','content' => 'Content 1','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 9','content' => 'Content 2','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 10','content' => 'Content 3','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 11','content' => 'Content 4','type_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Book 12','content' => 'Content 5','type_id' => 3,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
        ]);
    }
}
