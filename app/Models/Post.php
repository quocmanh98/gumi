<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected  $table = "posts";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class,'book_id','id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id', 'id')->orderBy('id','desc');
    }
}
