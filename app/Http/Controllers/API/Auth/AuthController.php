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

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->authService = new AuthService;
    }

    /**
     * Summary of register
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $dataInput = $request->all();
        $dataInput['uuid'] = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz' . time()));

        $userData = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'status' => 0,
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'unique_id' => $dataInput['uuid'],
            'activate_date' => Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
            'role_id' => 3,
        ];

        try {
            $result = $this->authService->createUser($dataInput, $userData);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Summary of registerActivate
     * @param int|null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerActivate(int $id=null)
    {
        try {
            $result = $this->authService->verifyUuid($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Summary of login
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $userData = $this->authService->verifyEmail($email);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }

        try {
            $result =  $this->authService->handleLogin($password, $userData);
            return $this->sendSuccess($result);
        }  catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Summary of changePassword
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $passwordOld = $request->input('password_old');
        $passwordNew = Hash::make($request->input('password_new'));
        $password = Auth::user()->password;
        $uuid = Auth::user()->uuid;

        try {
            $result =  $this->authService->handleChangePassword($passwordOld, $passwordNew, $password, $uuid);
            return $this->sendSuccess($result);
        }  catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Summary of forgotPassword
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->input('email');

        try {
            $result = $this->authService->handleForgotPassword($email);
            return $this->sendSuccess($result);
        } catch (\Exception $e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
