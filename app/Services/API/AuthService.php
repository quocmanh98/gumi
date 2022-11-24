<?php
namespace App\Services\API;

use App\Mail\Auth\ForgotPasswordMail;
use App\Repositories\Eloquent\API\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService extends BaseService
{

    protected $authRepository;
    public function __construct()
    {
        $this->authRepository = new AuthRepository;
    }

}
