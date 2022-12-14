<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\Auth\GenerateRequest;
use App\Http\Requests\API\Auth\LoginWithOtpRequest;
use App\Services\API\AuthOtpService;
use App\Services\API\AuthService;

class AuthOtpController extends BaseController
{
    protected $authService;
    protected $authOtpService;

    public function __construct()
    {
        $this->authService = new AuthService;
        $this->authOtpService = new AuthOtpService;
    }

    public function generate(GenerateRequest $request)
    {
        $phone = $request->phone;
        $email = $request->email;

        $result = $this->authOtpService->handleGenerate($phone,$email);
        return $this->sendSuccess($result);
    }


    public function loginWithOtp(LoginWithOtpRequest $request)
    {
        $user_id =  $request->user_id;
        $otp = $request->otp;

        try {
            $result = $this->authOtpService->handleLoginWithOtp($user_id,$otp);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }
    }

}
