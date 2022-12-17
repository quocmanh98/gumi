<?php
namespace App\Services\API;

use App\Mail\API\Auth\LoginOtpMail;
use App\Mail\API\Auth\RegisterMail;
use App\Repositories\Eloquent\API\AuthRepository;
use App\Repositories\Eloquent\API\VerificationCodeRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService extends BaseService
{
    protected $authRepository;
    protected $verificationCodeRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository;
        $this->verificationCodeRepository = new VerificationCodeRepository;
    }

    /**
     * Xử lý đăng ký
     * @param mixed $dataInput
     * @param mixed $userData
     * @return array<string>
     */
    public function createUser($dataInput, $userData)
    {
        $result = $this->authRepository->createUser($userData);
        if (!$result) {
            $this->sendError("Sorry ! Unable to create an account !");
        }
        $data =
            [
            'name' => $dataInput['username'],
            'email' => $dataInput['email'],
            'uuid' => $dataInput['uuid'],
        ];

        $email = Mail::to($dataInput['email'])->send(new RegisterMail($data));
        if (!$email) {
            $this->sendError("Sorry ! Send mail no success !");
        }
        return [
            'uuid' => $dataInput['uuid'],
            'message' => 'Send mail success !',
        ];

    }

    /**
     * Xử lý xác thực user đăng nhập
     * @param string $id
     * @return array<string>
     */
    public function verifyUuid($id)
    {
        if (empty($id)) {
            $this->sendError("Sorry !  Unable to process your request !");
        }

        $userData = $this->authRepository->verifyUuid($id);
        if (!$userData) {
            $this->sendError("Sorry ! We are unable to find your account !");
        }

        if (!$this->verifyExpireTime($userData->activation_date)) {
            $this->sendError("Sorry ! Activation link was expired !");
        }

        if ($userData->status == 1) {
            return [
                'message' => 'Your account is already activated !',
            ];
        }

        $result = $this->authRepository->updateStatusUser($id);
        if (!$result) {
            $this->sendError("Sorry ! Account activated failed !");
        }
        return [
            'message' => 'Account activated success',
        ];

    }

    /**
     * Xác minh thời gian hết hạn
     * @param mixed $regulateTime
     * @return bool
     */
    public function verifyExpireTime($regulateTime)
    {
        $currentTime = strtotime(now());
        $regulateTime = strtotime($regulateTime);
        $differenceTime = $currentTime - $regulateTime;

        if ($differenceTime < 3600) {
            return true;
        }
    }

    /**
     * Xác thực user qua email
     * @param string $email
     * @return mixed
     */
    public function verifyEmail(string $email)
    {
        $userData = $this->authRepository->verifyEmail($email);
        if (!$userData) {
            $this->sendError("Sorry ! Unauthorise ! ");
        }
        return $userData;
    }

    /**
     * Xử lý login
     * @param string $password
     * @param mixed $userData
     * @return array<string>
     */
    public function handleLogin(string $password,$userData)
    {
        $data = [
            'email' => $userData->email,
            'password' => $password,
        ];

        if (!Auth::attempt($data)) {
            $this->sendError("Error ! Login fail !");
        }

        if ($userData->status == 0) {
            $this->sendError("Please activate your account !");
        }

        $user = Auth::user();
        $success = [
            'token' => $user->createToken('token')->plainTextToken,
            'message' => 'Login Success',
        ];
        return $success;
    }

    /**
     * Xử lý cập nhật mật khẩu khi user đã đăng nhập
     * @param mixed $passwordOld
     * @param mixed $passwordNew
     * @param mixed $password
     * @param mixed $uuid
     * @return array<string>
     */
    public function handleChangePassword($passwordOld, $passwordNew, $password, $uuid)
    {
        if (!password_verify($passwordOld, $password)) {
            $this->sendError('Password old does not matched with database password');
        }

        $result = $this->authRepository->updatePassword($passwordNew, $uuid);
        if (!$result) {
            $this->sendError('Update password no success');
        }
        return [
            'message' => 'Update Password Success',
        ];
    }

    /**
     * Xử lý chức năng quên mật khẩu
     * @param mixed $email
     * @throws \Exception
     * @return array<string>
     */
    public function handleForgotPassword($dataInput)
    {
        $user = $this->authRepository->verifyEmail($dataInput['email']);
        if (!$user) {
            throw new \Exception("Email not exist ", 1);
        }

        # Generate An OTP
        $verificationCode = $this->handleGenerateOtp($dataInput, $user);
        $data = [
            'name' => $verificationCode->user->username,
            'message' => "Your OTP : " . $verificationCode->otp,
        ];

        $result = Mail::to($dataInput['email'])->send(new LoginOtpMail($data));

        if (!$result) {
            throw new \Exception("Error ! Send email fail ! ", 1);
        }

        return [
            'otp' => $verificationCode->otp,
            'userId' => $user->id,
            'message' => 'Success ! You have a new OTP in your email ! ',
        ];
    }

    /**
     * Xử lý tạo OTP cho chức năng quên mật khẩu
     * @param mixed $dataInput
     * @param mixed $user
     * @return mixed
     */
    public function handleGenerateOtp($dataInput, $user)
    {
        // User Does not Have Any Existing OTP
        $verificationCode = $this->verificationCodeRepository->verifyUser($user->id);
        $this->verificationCodeRepository->deleteOtp();
        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        // Create a New OTP
        return $this->verificationCodeRepository->createVerificationCode($dataInput, $user);
    }

    /**
     * Xử lý dữ liệu người dùng nhập OTP và password mới
     * Dùng trong chức năng quên mật khẩu
     * @param mixed $data
     * @throws \Exception
     * @return array<string>
     */
    public function handleForgotPasswordWithOtp($data)
    {
        $verificationCode = $this->verificationCodeRepository->verifyUserOtp($data);

        $now = Carbon::now();
        if (!$verificationCode) {
            throw new \Exception("Error ! Your OTP is not correct ! ", 1);
        } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            throw new \Exception("Error ! Your OTP has been expired ! ", 1);
        }

        $user = $this->authRepository->getUserId($data['user_id']);
        if (!$user) {
            throw new \Exception("Error ! No find User ! ", 1);
        }

        $password = Hash::make($data['password']);
        $result = $this->authRepository->updatePassword($password, $user->uuid);
        if (!$result) {
            throw new \Exception("Error ! Update password fail ! ", 1);
        }

        return [
            'message' => 'Success ! Update password success ',
        ];
    }

}
