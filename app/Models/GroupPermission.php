<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPermission extends Model
{
    protected  $table = "group_permissions";
    protected $guarded = [];

    public function permissions() {
        return $this->hasMany(Permission::class);
    }
}
