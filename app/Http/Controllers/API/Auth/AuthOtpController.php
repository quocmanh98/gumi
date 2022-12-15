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

    /**
     * Summary of generate
     * @param GenerateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(GenerateRequest $request)
    {
        $phone = $request->phone;
        $email = $request->email;

        $result = $this->authOtpService->handleGenerate($phone,$email);
        return $this->sendSuccess($result);
    }


    /**
     * Summary of loginWithOtp
     * @param LoginWithOtpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginWithOtp(LoginWithOtpRequest $request)
    {
        $userId =  $request->user_id;
        $otp = $request->otp;

        try {
            $result = $this->authOtpService->handleLoginWithOtp($userId,$otp);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }
    }

}
