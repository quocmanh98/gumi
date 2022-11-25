<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Services\API\AuthService;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $authService;
    public function __construct()
    {
        $this->authService = new AuthService;
    }
    public function register(RegisterRequest $request)
    {

        $dataInput = $request->all();
        $dataInput['uniid'] = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz' . time()));

        $userData = [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'status' => 0,
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'unique_id' => $dataInput['uniid'],
            'activate_date' => Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
            'role_id' => 3,
        ];

        try {
            $result = $this->authService->createUser($dataInput, $userData);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }

    }

    public function registerActivate($id=null)
    {
        try {
            $result = $this->authService->verifyUniid($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }
    }
}
