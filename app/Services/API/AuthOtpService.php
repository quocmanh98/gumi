<?php
namespace App\Services\API;

use Carbon\Carbon;
use App\Services\API\BaseService;
use App\Mail\API\Auth\LoginOtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\API\UserResource;
use App\Repositories\Eloquent\API\AuthRepository;
use App\Repositories\Eloquent\API\VerificationCodeRepository;

class AuthOtpService extends BaseService
{

    protected $authRepository;
    protected $verificationCodeRepository;
    public function __construct()
    {
        $this->authRepository = new AuthRepository;
        $this->verificationCodeRepository = new VerificationCodeRepository;
    }

    public function handleLoginWithOtp($userId,$otp){

        #Validation Logic
        $verificationCode   = $this->verificationCodeRepository->verifyUserOtp($userId,$otp);

        $now = Carbon::now();
        if (!$verificationCode) {
            $this->sendError("Sorry ! Your OTP is not correct !");
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            $this->sendError("Your OTP has been expired");
        }

        $user = $this->authRepository->getDataUserId($userId);

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::login($user);

            $success = [
                'token' => Auth::user()->createToken('token')->plainTextToken,
                'user' => new UserResource(Auth::user()),
                'message' => 'Login Success',
            ];
            return $success;
        }
        $this->sendError("Your Otp is not correct");
    }

    public function handleGenerate($phone,$email){
        # Generate An OTP
        $verificationCode = $this->generateOtp($phone);
        $data = [
            'name' => $verificationCode->user->username,
            'message' => "Your OTP To Login: ".$verificationCode->otp,
        ];
        $result = Mail::to($email)->send(new LoginOtpMail($data));
            if ($result == true) {
                return [
                    'message' => 'Please check your email to get the otp code ',
                ];
            }
    }

    public function generateOtp($phone)
    {
        $user = $this->authRepository->verifyPhone($phone);

        # User Does not Have Any Existing OTP
        $verificationCode = $this->verificationCodeRepository->verifyUser($user->id);
        $this->verificationCodeRepository->deleteOtp();
        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return $this->verificationCodeRepository->createVerificationCode($user->id);
    }
}
