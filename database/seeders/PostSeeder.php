<?php

namespace Database\Seeders;

use App\Models\Modules;
use App\Models\Post;
use App\Models\Posts;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::insert([
            ['title' => 'Post 1','content' => 'Content 1','status' => 0,'book_id' => 2,'user_id' => 1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Post 2','content' => 'Content 2','status' => 1,'book_id' => 3,'user_id' => 1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Post 3','content' => 'Content 3','status' => 1,'book_id' => 4,'user_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Post 4','content' => 'Content 4','status' => 1,'book_id' => 5,'user_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Post 5','content' => 'Content 5','status' => 1,'book_id' => 6,'user_id' => 1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Post 6','content' => 'Content 6','status' => 1,'book_id' => 7,'user_id' => 1,'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['title' => 'Post 7','content' => 'Content 7','status' => 1,'book_id' => 8,'user_id' => 2,'created_at' => Carbon::now(),'updated_at' => Carbon::now()]
        ]);
    }
}
