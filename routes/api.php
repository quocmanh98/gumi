<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\AuthOtpController;
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

Route::controller(AuthOtpController::class)->group(function(){
    // Route::get('/otp/login', 'login')->name('otp.login');
    Route::post('/otp/generate', 'generate')->name('otp.generate');
    Route::post('/otp/login', 'loginWithOtp')->name('otp.getlogin');
    // Route::get('/otp/verification/{user_id}', 'verification')->name('otp.verification');
});
