<?php
namespace App\Services\API;

use App\Repositories\Eloquent\API\UserRepository;

class VerificationCodeService extends BaseService
{
    protected $userRepository;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

}
