<?php
namespace App\Services\API;

use App\Mail\API\Auth\RegisterMail;
use App\Repositories\Eloquent\API\AuthRepository;
use Illuminate\Support\Facades\Mail;

class AuthService extends BaseService
{

    protected $authRepository;
    public function __construct()
    {
        $this->authRepository = new AuthRepository;
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
}
