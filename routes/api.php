<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\AuthOtpController;
use App\Http\Controllers\API\Auth\GoogleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/register/activate/{uniid}', [AuthController::class, 'registerActivate'])->name('auth.register_activate');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot_password');
Route::get('/refresh-token', [AuthController::class, 'refreshToken'])->name('auth.refresh_token');

Route::controller(AuthOtpController::class)->group(function(){
    Route::post('/otp/generate', 'generate')->name('otp.generate');
    Route::post('/otp/login', 'loginWithOtp')->name('otp.login');
});

Route::prefix('/')->middleware('auth:sanctum')->group(function () {
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('auth.change_password');
    Route::get('token', [AuthController::class, 'getToken'])->name('auth.get_token');

    Route::prefix('users/')->name('users.')->middleware('auth:sanctum')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::post('', [UserController::class, 'store'])->name('store');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::put('{user}', [UserController::class, 'update'])->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});



