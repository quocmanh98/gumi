<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\Auth\GenerateRequest;
use App\Http\Requests\API\Auth\LoginWithOtpRequest;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\API\AuthOtpService;
use App\Services\API\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // hidden : user_id
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
