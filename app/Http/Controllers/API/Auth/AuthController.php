<?php

namespace App\Http\Controllers\API\Auth;

use Carbon\Carbon;
use App\Services\API\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use App\Http\Requests\API\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\Auth\ForgotPasswordWithOtpRequest;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService;
    }

    /**
     * Chức năng đăng ký tài khoản
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
            'gender' => $request->input('gender'),
            'status' => 0,
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'uuid' => $dataInput['uuid'],
            'role_id' => 1,
            'activation_date' => Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
        ];
        $hasFile = $request->hasFile('thumbnail');
        $thumbnail = $request->thumbnail;

        try {
            $result = $this->authService->createUser($dataInput, $userData, $hasFile, $thumbnail);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * User nhấn link xác thực đăng ký
     * @param int|null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerActivate($id)
    {
        try {
            $result = $this->authService->verifyUuid($id);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Chức năng đăng nhập
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
            $result = $this->authService->handleLogin($password, $userData);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Chức năng: Thay đổi mật khẩu
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
            $result = $this->authService->handleChangePassword($passwordOld, $passwordNew, $password, $uuid);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Chức năng quên mật khẩu
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $dataInput = $request->all();
        $dataInput['uuid'] = md5(str_shuffle('abcdefghijklmnopqrstuvwxyz' . time()));

        try {
            $result = $this->authService->handleForgotPassword($dataInput);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Chức năng nhập OTP + nhập password mới
     * dùng trong chức năng quên mật khẩu
     * @param ForgotPasswordWithOtpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function forgotPasswordWithOtp(ForgotPasswordWithOtpRequest $request)
    {
        $dataInput = $request->all();

        try {
            $result = $this->authService->handleForgotPasswordWithOtp($dataInput);
            return $this->sendSuccess($result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Chức năng logout tài khoản
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        Session::forget('_token');
        return $this->sendSuccess('Logout success !');
    }
}
