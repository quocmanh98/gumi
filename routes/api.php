<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\GroupPermissionController;

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

    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('register');
        Route::get('register/activate/{uuid}', 'registerActivate')->name('register_activate');
        Route::post('login', 'login')->name('login');
        Route::delete('logout', 'logout')->name('logout');
        Route::put('change-password', 'changePassword')->name('change_password')->middleware('auth:sanctum');
        Route::delete('logout', 'logout')->name('logout');
        Route::post('forgot-password', 'forgotPassword')->name('forgot_password');

        Route::prefix('otp/')->name('otp.')->group(function () {
            Route::post('forgot-password', 'forgotPasswordWithOtp')->name('forgot_password');
        });
    });

});

Route::prefix('/')->middleware('auth:sanctum')->group(function () {

    // Route: User
    Route::controller(UserController::class)->group(function () {
        Route::prefix('users/')->name('users.')->group(function () {
            Route::get('', 'index')->name('index');
        });
        Route::prefix('user/')->name('user.')->group(function () {
            Route::post('', 'store')->name('store');
            Route::get('{user_id}', 'show')->name('show');
            Route::post('action', 'action')->name('action');
            Route::put('{user_id}', 'update')->name('update');
            Route::delete('{user_id}', 'destroy')->name('destroy');
            Route::put('thumbnail/', 'updateThumbnail')->name('thumbnail.update');
        });
    });

    // Route: Post
    Route::controller(PostController::class)->group(function () {
        Route::prefix('posts/')->name('posts.')->group(function () {
            Route::get('', 'index')->name('index');
        });

        Route::prefix('post/')->name('post.')->group(function () {
            Route::post('', 'store')->name('store');
            Route::get('{post_id}', 'show')->name('show');
            Route::get('action', 'action')->name('action');
            Route::put('{post_id}', 'update')->name('update');
            Route::delete('{post_id}', 'destroy')->name('destroy');
            Route::put('thumbnail', 'updateThumbnail')->name('thumbnail.update');

            Route::prefix('images/')->name('images.')->group(function () {
                Route::get('{post_id}', 'getImages')->name('get_images');
            });

            Route::prefix('image/')->name('image.')->group(function () {
                Route::delete('{image_id}', 'deleteImage')->name('delete_image');
                Route::put('{image_id}', 'updateImage')->name('update_image');
                Route::post('{post_id}', 'uploadImage')->name('upload_image');
            });
        });
    });

    // Route: Role
    Route::controller(RoleController::class)->group(function () {
        Route::prefix('roles/')->name('roles.')->group(function () {
            Route::get('', 'index')->name('index');
        });
        Route::prefix('role/')->name('role.')->group(function () {
            Route::post('', 'store')->name('store');
            Route::get('{role_id}', 'show')->name('show');
            Route::get('action', 'action')->name('action');
            Route::put('{role_id}', 'update')->name('update');
            Route::delete('{role_id}', 'destroy')->name('destroy');
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

    // Group Permission Controller
    Route::controller(GroupPermissionController::class)->group(function () {
        Route::prefix('group/permission')->name('group.permission.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{group_permission_id}', 'show')->name('show');
            Route::put('/{group_permission_id}', 'update')->name('update');
            Route::delete('/{group_permission_id}', 'destroy')->name('destroy');
        });
    });
});
