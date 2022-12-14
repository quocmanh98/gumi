<?php

use App\Http\Controllers\Admin\GroupPermissionController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\AuthOtpController;
use App\Http\Controllers\API\MultipleImagePostController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RoleController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')
        ->name('auth.register');
    Route::get('/register/activate/{uniid}', 'registerActivate')
        ->name('auth.register_activate');
    Route::get('/login', 'login')
        ->name('auth.login');
    Route::post('forgot-password', 'forgotPassword')
        ->name('auth.forgot_password');
    Route::post('change-password', 'changePassword')
        ->name('auth.change_password');
});

Route::controller(AuthOtpController::class)->group(function () {
    Route::prefix('otp/')->name('users.')->group(function () {
        Route::post('generate', 'generate')
            ->name('otp.generate');
        Route::post('login', 'loginWithOtp')
            ->name('otp.login');
    });
});

Route::prefix('/')->middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{user}', 'show')->name('show');
            Route::put('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });
    });

    Route::controller(PostController::class)->group(function () {
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{post}', 'show')->name('show');
            Route::put('/{post}', 'update')->name('update');
            Route::delete('/{post}', 'destroy')->name('destroy');
        });
    });

    Route::post('{post}/images', [MultipleImagePostController::class, 'store'])
        ->name('images.store');

    Route::controller(RoleController::class)->group(function () {
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{role}', 'show')->name('show');
            Route::put('/{role}', 'update')->name('update');
            Route::delete('/{role}', 'destroy')->name('destroy');
        });
    });

    Route::prefix('permissions/')->name('group.permission.')->group(function () {

        // Group Permission Controller
        Route::prefix('groups/')->name('roles.')->group(function () {
            Route::controller(GroupPermissionController::class)->group(function () {
                Route::get('', 'index')->name('index');
                Route::post('', 'store')->name('store');
                Route::get('{group}', 'show')->name('show');
                Route::put('{group}', 'update')->name('update');
                Route::delete('{group}', 'destroy')->name('destroy');
            });
        });

        // Permission Controller
        Route::controller(PermissionController::class)->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('', 'store')->name('store');
            Route::get('{permission}', 'show')->name('show');
            Route::put('{permission}', 'update')->name('update');
            Route::delete('{permission}', 'destroy')->name('destroy');
        });
    });
});
