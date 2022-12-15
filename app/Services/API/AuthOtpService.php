<?php
namespace App\Services\API;

use App\Mail\API\Auth\LoginOtpMail;
use App\Repositories\Eloquent\API\AuthRepository;
use App\Repositories\Eloquent\API\VerificationCodeRepository;
use App\Services\API\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthOtpService extends BaseService
{
    protected $authRepository;
    protected $verificationCodeRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository;
        $this->verificationCodeRepository = new VerificationCodeRepository;
    }

    /**
     * Summary of handleLoginWithOtp
     * @param mixed $userId
     * @param mixed $otp
     * @return array
     */
    public function handleLoginWithOtp($userId, $otp)
    {
        #Validation Logic
        $verificationCode = $this->verificationCodeRepository->verifyUserOtp($userId, $otp);
        $now = Carbon::now();

        if (!$verificationCode) {
            $this->sendError("Sorry ! Your OTP is not correct !");
        } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            $this->sendError("Your OTP has been expired");
        }

        $user = $this->authRepository->getDataUserId($userId);
        if ($user) {
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now(),
            ]);

            Auth::login($user);

            $success = [
                'token' =>  $user->createToken('token')->plainTextToken,
                'message' => 'Login Success',
            ];
            return $success;
        }
        $this->sendError("OTP is not correct");
    }

    /**
     * Summary of handleGenerate
     * @param int $phone
     * @param mixed $email
     * @return array<string>
     */
    public function handleGenerate(int $phone, $email)
    {
        # Generate An OTP
        $verificationCode = $this->generateOtp($phone);
        $data = [
            'name' => $verificationCode->user->username,
            'message' => "Your OTP To Login: " . $verificationCode->otp,
        ];

        $result = Mail::to($email)->send(new LoginOtpMail($data));

        if ($result == true) {
            return [
                'message' => 'Success ! Please check your email to get the otp code ',
            ];
        }
    }

    /**
     * Summary of generateOtp
     * @param mixed $phone
     * @return mixed
     */
    public function generateOtp($phone)
    {
        $user = $this->authRepository->verifyPhone($phone);

        // User Does not Have Any Existing OTP
        $verificationCode = $this->verificationCodeRepository->verifyUser($user->id);
        $this->verificationCodeRepository->deleteOtp();
        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        // Create a New OTP
        return $this->verificationCodeRepository->createVerificationCode($user->id);
    }
}
