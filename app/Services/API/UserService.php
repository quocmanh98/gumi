<?php
namespace App\Services\API;

use App\Repositories\Eloquent\API\UserRepository;

class UserService extends BaseService
{

    protected $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

}
