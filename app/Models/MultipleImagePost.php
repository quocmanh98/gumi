<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleImagePost extends Model
{
    use HasFactory;
    protected  $table = "images_post";
    protected $guarded = [];
}