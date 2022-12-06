<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\Demo\DemoAuthController;
use App\Http\Controllers\API\Auth\GoogleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\API\Auth\AuthOtpController;
use App\Http\Controllers\Admin\GroupPermissionController;
use App\Http\Controllers\API\MultipleImagePostController;

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

    Route::prefix('users/')->name('users.')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::post('', [UserController::class, 'store'])->name('store');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::put('{user}', [UserController::class, 'update'])->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('posts/')->name('posts.')->group(function () {
        Route::get('', [PostController::class, 'index'])->name('index')->can('viewAny',Post::class);
        Route::post('', [PostController::class, 'store'])->name('store');
        Route::get('{post}', [PostController::class, 'show'])->name('show');
        // Route::put('{post}', [PostController::class, 'update'])->name('update');
        Route::post('{post}', [PostController::class, 'update'])->name('update');
        Route::delete('{post}', [PostController::class, 'destroy'])->name('destroy');

        Route::post('{post}/images', [MultipleImagePostController::class, 'store'])->name('images.store');
    });

    Route::prefix('roles/')->name('roles.')->group(function () {
        Route::get('', [RoleController::class, 'index'])->name('index');
        Route::post('', [RoleController::class, 'store'])->name('store');
        Route::get('{role}', [RoleController::class, 'show'])->name('show');
        Route::put('{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('permissions/')->name('group.permission.')->group(function () {

        // Group Permission Controller
        Route::prefix('groups/')->name('roles.')->group(function () {
            Route::get('', [GroupPermissionController::class, 'index'])->name('index');
            Route::post('', [GroupPermissionController::class, 'store'])->name('store');
            Route::get('{group}', [GroupPermissionController::class, 'show'])->name('show');
            Route::put('{group}', [RoleGroupPermissionControllerController::class, 'update'])->name('update');
            Route::delete('{group}', [GroupPermissionController::class, 'destroy'])->name('destroy');
        });

        // Permission Controller
        Route::get('', [PermissionController::class, 'index'])->name('index');
        Route::post('', [PermissionController::class, 'store'])->name('store');
        Route::get('{permission}', [PermissionController::class, 'show'])->name('show');
        Route::put('{permission}', [PermissionController::class, 'update'])->name('update');
        Route::delete('{permission}', [PermissionController::class, 'delete'])->name('delete');
    });
});


Route::get('demo/login', [DemoAuthController::class, 'login']);
Route::post('demo/login', [DemoAuthController::class, 'handleLogin'])->name('demo.login');


