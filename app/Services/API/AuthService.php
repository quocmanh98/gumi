<?php
namespace App\Services\API;

use App\Http\Resources\API\UserResource;
use App\Mail\API\Auth\LoginOtpMail;
use App\Mail\API\Auth\RegisterMail;
use App\Models\User;
use App\Repositories\Eloquent\API\AuthRepository;
use App\Repositories\Eloquent\API\VerificationCodeRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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

    public function createUser($dataInput, $userData)
    {
        $result = $this->authRepository->createUser($userData);
        if ($result == false) {
            $this->sendError("Sorry !  Unable to create an account !");
        } else {

            $data =
                [
                'name' => $dataInput['username'],
                'email' => $dataInput['email'],
                'unique_id' => $dataInput['uniid'],
            ];

            $result = Mail::to($dataInput['email'])->send(new RegisterMail($data));
            if ($result == true) {
                return [
                    'message' => 'Send Mail Success !',
                ];
            }
        }
    }

    public function verifyUniid($id)
    {
        if (!empty($id)) {

            $userData = $this->authRepository->verifyUniid($id);
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

    public function verifyExpireTime($regTime)
    {

        $currTime = strtotime(now());
        $regTime = strtotime($regTime);
        $diffTime = $currTime - $regTime;

        if ($diffTime < 3600) {
            return true;
        }

    }

    public function verifyEmail($email)
    {
        $userData = $this->authRepository->verifyEmail($email);
        if ($userData) {
            return $userData;
        }
        $this->sendError("Sorry ! Unauthorised ! ");
    }

    public function handleLogin($password, $userData)
    {

        if (password_verify($password, $userData->password)) {

            if ($userData->status == 1) {

                $data = [
                    'email' => $userData->email,
                    'password' => $password,
                ];

                if (Auth::attempt($data)) {
                    $success = [
                        'token' => Auth::user()->createToken('token')->plainTextToken,
                        'user' => new UserResource($userData),
                        'message' => 'Login Success',
                    ];
                    return $success;
                }

            }
            $this->sendError("Please activate your account !");
        }
        $this->sendError("Sorry ! Unauthorised ! ");

    }

}
