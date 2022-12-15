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

    /**
     * Summary of verifyUser
     * @param mixed $user
     * @return mixed
     */
    public function verifyUser($user)
    {
        $result = $this->verificationCode->select('*')
            ->where('user_id', $user)
            ->first();
        return $result;
    }

    /**
     * Summary of verifyUserOtp
     * @param mixed $userId
     * @param mixed $otp
     * @return mixed
     */
    public function verifyUserOtp($userId,$otp)
    {
        $result = $this->verificationCode->select('*')
            ->where('user_id', $userId)->where('otp', $otp)
            ->first();
        return $result;
    }

    /**
     * Summary of createVerificationCode
     * @param mixed $userId
     * @return mixed
     */
    public function createVerificationCode($userId)
    {
        return $this->verificationCode->create([
            'user_id' => $userId,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    /**
     * Summary of deleteOtp
     * @return mixed
     */
    public function deleteOtp()
    {
        return $this->verificationCode->truncate();
    }
}
