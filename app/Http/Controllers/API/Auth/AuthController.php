<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Requests\API\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Services\API\AuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Laravel\Sanctum\PersonalAccessToken;

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
            'name' => $request->input('name'),
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

    public function login(LoginRequest $request){

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $userData = $this->authService->verifyEmail($email);
        } catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }

        try {
            $result =  $this->authService->handleLogin($password,$userData);
            return $this->sendSuccess($result);
        }  catch (\Exception$e) {
            return $this->sendError(null,$e->getMessage());
        }

    }

    public function changePassword(ChangePasswordRequest $request)
    {

        $passwordOld = $request->input('password_old');
        $passwordNew = Hash::make($request->input('password_new'));
        $password = Auth::user()->password;
        $uniid = Auth::user()->unique_id;

        try {
            $result =   $this->authService->handleChangePassword($passwordOld,$passwordNew,$password,$uniid);
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
            return $this->sendSuccess( $result);
        } catch (\Exception $e) {
            return $this->sendError(null,$e->getMessage());
        }

    }

    public function getToken(){
        $user = Auth::user();
        try {
            $result = $this->authService->getToken($user);
            return $this->sendSuccess( $result);
        } catch (\Exception $e) {
            return $this->sendError(null,$e->getMessage());
        }
    }

    // public function refreshToken(Request $request){
    //     $token = $request->header('authorization');
    //     $token = trim(str_replace('Bearer', '', $token));
    //     $token = PersonalAccessToken::findToken($token);
    //     if ($token) {
    //         $tokenCreated = $token->created_at;
    //         $expire = Carbon::parse($tokenCreated)->addMinutes(config('sanctum.expiration'));
    //         if (Carbon::now() >= $expire) {
    //             $tokenId = $token->id;
    //             $userId = $token->tokenable_id;
    //             $user = User::findOrFail($userId);
    //             // $user->tokens()->delete();
    //             $newToken = $user->createToken('auth_token')->plainTextToken;
    //             $success = [
    //                 'token' => $newToken,
    //                 'name' => $user->name,
    //                 'status' => 200,
    //             ];
    //             return $this->sendSuccess($success, 'Create Token Success !');
    //         } else {
    //             return $this->sendSuccess([], 'Unexpires');
    //         }
    //     } else {
    //         return $this->sendError(null,'Unauthorized');
    //     }
    // }
}
