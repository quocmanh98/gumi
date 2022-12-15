<?php

namespace App\Http\Controllers\API\Auth;

use App\Services\API\UserService;
use App\Http\Controllers\BaseController;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends BaseController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    /**
     * Summary of login
     * @return mixed
     */
    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Summary of callbackGoogle
     * @return \Illuminate\Http\JsonResponse
     */
    public function callbackGoogle()
    {
        try {
            $result = $this->userService->handleCallbackGoogle();
            return $this->sendSuccess( $result);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
