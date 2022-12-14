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

    public function createUser($data_input, $user_data)
    {
        $result = $this->authRepository->createUser($user_data);

        if ($result == false) {
            $this->sendError("Sorry ! Unable to create an account !");
        } else {
            $data =
            [
                'name' => $data_input['username'],
                'email' => $data_input['email'],
                'uuid' => $data_input['uuid'],
            ];

            $result = Mail::to($data_input['email'])->send(new RegisterMail($data));
            if ($result == true) {
                return [
                    'message' => 'Send Mail Success !',
                ];
            }
        }

    }

    public function verifyUuid($id)
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

    public function verifyExpireTime($regulate_time)
    {
        $current_time = strtotime(now());
        $regulate_time = strtotime($regulate_time);
        $difference_time =  $current_time -  $regulate_time;

        if ($difference_time < 3600) {
            return true;
        }
    }

    public function verifyEmail($email)
    {
        $userData = $this->authRepository->verifyEmail($email);
        if ($userData) {
            return $userData;
        }

        $this->sendError("Sorry ! Unauthorise ! ");
    }

    public function handleLogin($password, $user_data)
    {
        if (password_verify($password, $user_data->password)) {
            if ($user_data->status == 1) {
                $data = [
                    'email' => $user_data->email,
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


    public function handleChangePassword($password_old, $password_new, $password, $uuid)
    {
        if (password_verify($password_old, $password)) {
            $result = $this->authRepository->updatePassword($password_new, $uuid );

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

    public function handleForgotPassword($email)
    {
        $user = $this->authRepository->verifyEmail($email);

        if ($user) {
            $password_new = rand(123456789, 999999999);
            $password_new_hash = Hash::make($password_new);
            $data = [
                'username' => $user->username,
                'password_new' => $password_new,
                'password_new_hash' => $password_new_hash,
            ];

            Mail::to($email)->send(new ForgotPasswordMail($data));
            $result = $this->authRepository->updatePasswordByEmail($password_new_hash, $email);

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
