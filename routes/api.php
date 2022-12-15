<?php

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

// Route: Auth
Route::prefix('auth/')->name('auth.')->group(function () {

    Route::controller(AuthOtpController::class)->group(function () {
        Route::prefix('otp/')->name('otp.')->group(function () {
            Route::post('generate', 'generate')->name('generate');
            Route::post('login', 'loginWithOtp')->name('login');
        });
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('register');
        Route::get('register/activate/{uniid}', 'registerActivate')->name('register_activate');
        Route::get('login', 'login') ->name('login');
        Route::post('forgot-password', 'forgotPassword') ->name('forgot_password');
        Route::post('change-password', 'changePassword')->name('change_password');
    });

});

Route::prefix('admin/')->middleware('auth:sanctum')->group(function () {

    // Route: User
    Route::controller(UserController::class)->group(function () {
        Route::prefix('users/')->name('users.')->group(function () {
            Route::get('', 'index')->name('index');
        });
        Route::prefix('user/')->name('user.')->group(function () {
            Route::post('', 'store')->name('store');
            Route::get('{user_id}', 'show')->name('show');
            Route::get('action', 'action')->name('action');
            Route::put('{user_id}', 'update')->name('update');
            Route::delete('{user_id}', 'destroy')->name('destroy');
        });
    });

    // Route: Post
    Route::controller(PostController::class)->group(function () {
        Route::prefix('posts/')->name('posts.')->group(function () {
            Route::get('', 'index')->name('index');
        });
        Route::prefix('post/')->name('post.')->group(function () {
            Route::post('', 'store')->name('store');
            Route::get('{post}', 'show')->name('show');
            Route::get('action', 'action')->name('action');
            Route::put('{post}', 'update')->name('update');
            Route::delete('{post}', 'destroy')->name('destroy');
        });
    });

    // Route: Multiple Image Post
    Route::controller(MultipleImagePostController::class)->group(function () {
        Route::prefix('posts/')->name('post.')->group(function () {
            Route::prefix('images/')->name('posts.images')->group(function () {
                Route::get('{post_id}', 'index')->name('index');
            });
            Route::prefix('image/')->name('posts.image.')->group(function () {
                Route::delete('delete/{image_id}', 'delete')->name('delete');
                Route::put('update/{image_id}', 'update')->name('update');
                Route::post('{post_id}', 'store')->name('store');
                Route::get('action', 'action')->name('action');
            });
        });
    });

    // Route: Role
    Route::controller(RoleController::class)->group(function () {
        Route::prefix('roles/')->name('roles.')->group(function () {
            Route::get('', 'index')->name('index');
        });
        Route::prefix('role')->name('role.')->group(function () {
            Route::post('', 'store')->name('store');
            Route::get('{role}', 'show')->name('show');
            Route::get('action', 'action')->name('action');
            Route::put('{role}', 'update')->name('update');
            Route::delete('{role}', 'destroy')->name('destroy');
        });
    });

    // Route: Group Permission
    Route::controller(GroupPermissionController::class)->group(function () {
        Route::prefix('group/permission/')->name('group.permission.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('', 'store')->name('store');
            Route::get('{group_permission_id}', 'show')->name('show');
            Route::put('{group_permission_id}', 'update')->name('update');
            Route::delete('{group_permission_id}', 'destroy')->name('destroy');
            Route::get('action', 'action')->name('action');
        });
    });

    // Route: Permission
    Route::controller(PermissionController::class)->group(function () {
        Route::get('permissions', 'index')->name('index');

        Route::prefix('permission/')->name('permission.')->group(function () {
            Route::post('', 'store')->name('store');
            Route::get('{permission_id}', 'show')->name('show');
            Route::put('{permission_id}', 'update')->name('update');
            Route::delete('{permission_id}', 'destroy')->name('destroy');
            Route::get('action', 'action')->name('action');
        });

    });
});
