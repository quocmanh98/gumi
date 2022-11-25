<?php
namespace App\Repositories\Eloquent\API;

use App\Models\VerificationCode;
use Carbon\Carbon;

class VerificationCodeRepository extends BaseRepository
{

    protected $verificationCode;

    public function __construct()
    {
        $this->verificationCode = new VerificationCode();
    }

    public function verifyUser($user)
    {
        $result = $this->verificationCode->select('*')
            ->where('user_id', $user)
            ->first();
        return $result;
    }

    public function verifyUserOtp( $userId,$otp)
    {
        $result = $this->verificationCode->select('*')
            ->where('user_id', $userId)->where('otp', $otp)
            ->first();
        return $result;
    }

    public function createVerificationCode($userId)
    {
        return $this->verificationCode->create([
            'user_id' => $userId,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    public function deleteOtp(){
        return $this->verificationCode->truncate();
    }
}
