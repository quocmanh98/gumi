<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected  $table = "comment";
    protected $guarded = [];

    public function cus(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'reply_id', 'id');
    }
}
