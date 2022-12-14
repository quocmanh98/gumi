<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\ForgotPasswordRequest;
use App\Services\API\AuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService;
    }

    public function register(RegisterRequest $request)
    {
        $data_input = $request->all();
        $data_input['uuid'] = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz' . time()));

        $user_data = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'status' => 0,
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'unique_id' => $data_input['uuid'],
            'activate_date' => Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
            'role_id' => 3,
        ];

        try {
            $result = $this->authService->createUser($data_input, $user_data);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }
    }

    public function registerActivate($id=null)
    {
        try {
            $result = $this->authService->verifyUuid($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $user_data = $this->authService->verifyEmail($email);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }

        try {
            $result =  $this->authService->handleLogin($password, $user_data);
            return $this->sendSuccess($result);
        }  catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $password_old = $request->input('password_old');
        $password_new = Hash::make($request->input('password_new'));
        $password = Auth::user()->password;
        $uuid = Auth::user()->uuid;

        try {
            $result =  $this->authService->handleChangePassword($password_old, $password_new, $password,$uuid);
            return $this->sendSuccess($result);
        }  catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->input('email');

        try {
            $result = $this->authService->handleForgotPassword($email);
            return $this->sendSuccess($result);
        } catch (\Exception $e) {
            return $this->sendError(null,$e->getMessage());
        }
    }
}
