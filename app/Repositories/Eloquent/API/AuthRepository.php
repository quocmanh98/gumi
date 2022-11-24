<?php
namespace App\Repositories\Eloquent\API;

use App\Models\User;

class AuthRepository extends BaseRepository
{

    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

}
