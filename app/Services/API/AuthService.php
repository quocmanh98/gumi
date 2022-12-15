<?php
namespace App\Services\API;

use App\Mail\API\Auth\RegisterMail;
use App\Mail\API\Auth\ForgotPasswordMail;
use App\Repositories\Eloquent\API\AuthRepository;
use App\Repositories\Eloquent\API\VerificationCodeRepository;
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
     * Summary of createUser
     * @param mixed $dataInput
     * @param mixed $userData
     * @return array<string>
     */
    public function createUser($dataInput, $userData)
    {
        $result = $this->authRepository->createUser($userData);

        if ($result == false) {
            $this->sendError("Sorry ! Unable to create an account !");
        } else {
            $data =
            [
                'name' => $dataInput['username'],
                'email' => $dataInput['email'],
                'uuid' => $dataInput['uuid'],
            ];

            $result = Mail::to($dataInput['email'])->send(new RegisterMail($data));
            if ($result == true) {
                return [
                    'message' => 'Send Mail Success !',
                ];
            }
        }

    }

    /**
     * Summary of verifyUuid
     * @param string $id
     * @return array<string>
     */
    public function verifyUuid(string $id)
    {
        if (!empty($id)) {

            $userData = $this->authRepository->verifyUuid($id);
            if ($userData) {
                if ($this->verifyExpireTime($userData->activate_date)) {

                    if ($userData->status == 0) {
                        $result = $this->authRepository->updateStatusUser($id);
                        if ($result) {
                            return [
                                'message' => 'Account activated success',
                            ];
                        }
                    }
                    return [
                        'message' => 'Your account is already activated !',
                    ];
                }

                $this->sendError("Sorry ! Activation link was expired !");
            }

            $this->sendError("Sorry ! We are unable to find your account !");
        }

        $this->sendError("Sorry !  Unable to process your request !");
    }

    /**
     * Summary of verifyExpireTime
     * @param mixed $regulateTime
     * @return bool
     */
    public function verifyExpireTime($regulateTime)
    {
        $currentTime = strtotime(now());
        $regulateTime = strtotime($regulateTime);
        $differenceTime =  $currentTime -  $regulateTime;

        if ($differenceTime < 3600) {
            return true;
        }
    }

    /**
     * Summary of verifyEmail
     * @param string $email
     * @return mixed
     */
    public function verifyEmail(string $email)
    {
        $userData = $this->authRepository->verifyEmail($email);
        if ($userData) {
            return $userData;
        }

        $this->sendError("Sorry ! Unauthorise ! ");
    }

    /**
     * Summary of handleLogin
     * @param string $password
     * @param mixed $userData
     * @return array<string>
     */
    public function handleLogin(string $password, $userData)
    {
        if (password_verify($password, $userData->password)) {
            if ($userData->status == 1) {
                $data = [
                    'email' => $userData->email,
                    'password' => $password,
                ];

                if (Auth::attempt($data)) {
                    $user = Auth::user();
                    $success = [
                        'token' => $user->createToken('token')->plainTextToken,
                        'message' => 'Login Success',
                    ];
                    return $success;
                }
            }
            $this->sendError("Please activate your account !");
        }
        $this->sendError("Sorry ! Unauthorised ! ");
    }


    /**
     * Summary of handleChangePassword
     * @param mixed $passwordOld
     * @param mixed $passwordNew
     * @param mixed $password
     * @param mixed $uuid
     * @return array<string>
     */
    public function handleChangePassword($passwordOld, $passwordNew, $password, $uuid)
    {
        if (password_verify($passwordOld, $password)) {
            $result = $this->authRepository->updatePassword($passwordNew, $uuid );

            if ($result) {
                return [
                    'message' => 'Update Password Success',
                ];
            }
            $this->sendError('Update password no success');
        } else {
            $this->sendError('Password old does not matched with database password');
        }
    }

    /**
     * Summary of handleForgotPassword
     * @param mixed $email
     * @throws \Exception
     * @return array<string>
     */
    public function handleForgotPassword($email)
    {
        $user = $this->authRepository->verifyEmail($email);

        if ($user) {
            $passwordNew = rand(123456789, 999999999);
            $passwordNewHash = Hash::make($passwordNew);
            $data = [
                'username' => $user->username,
                'password_new' => $passwordNew,
                'password_new_hash' => $passwordNewHash,
            ];

            Mail::to($email)->send(new ForgotPasswordMail($data));
            $result = $this->authRepository->updatePasswordByEmail($passwordNewHash, $email);

            if($result){
                return [
                    'message' => 'Success ! Please check your email to get the password new ',
                ];
            }
        } else {
            throw new \Exception("Email not exist ", 1);
        }
    }
}
