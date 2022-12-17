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
     * Kiểm tra tồn tại user trong bảng Verification Codes
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

    /** Kiểm tra tồn tại user và otp trong bảng Verification Codes
     * Summary of verifyUserOtp
     * @param mixed $userId
     * @param mixed $otp
     * @return mixed
     */
    public function verifyUserOtp($data)
    {
        $result = $this->verificationCode->select('*')
            ->where('user_id', $data['user_id'])->where('otp', $data['otp'])
            ->first();
        return $result;
    }

    /**
     * Tạo mã otp cho user
     * @param mixed $userId
     * @return mixed
     */
    public function createVerificationCode($data, $user)
    {
        return $this->verificationCode
            ->create([
                'user_id' => $user->id,
                'otp' => rand(123456, 999999),
                'expire_at' => Carbon::now()->addMinutes(10),
                'email' => $user->email
                ]);
    }

    /**
     * Xóa tất cả OTP
     * @return mixed
     */
    public function deleteOtp()
    {
        return $this->verificationCode->truncate();
    }
}
