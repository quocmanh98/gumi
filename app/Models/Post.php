<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected  $table = "posts";
    protected $guarded = [];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Summary of book
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    /**
     * Summary of comments
     * @return \Illuminate\Database\Query\Builder
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id', 'id')->orderBy('id', 'desc');
    }
}
