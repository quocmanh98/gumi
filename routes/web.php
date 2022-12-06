<?php

use App\Http\Controllers\API\Auth\GoogleController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Demo\DemoAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('', [ClientController::class, 'index']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::prefix('google/')->name('google.')->group(function () {
    Route::get('login', [GoogleController::class, 'login'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackGoogle'])->name('callback');

})->middleware('verified');

Route::group(['middleware' => ['role:admin']], function () {

    Route::prefix('client/')->name('client.')->middleware('auth', 'Impersonate')->group(function () {

        Route::resource('', ClientController::class);
        Route::get('decentralizate/{id}', [ClientController::class, 'decentralizate'])->name('decentralizate');
        Route::get('role-assignment/{id}', [ClientController::class, 'roleAssignment'])->name('role_assignment');
        Route::post('insert-roles/{id}', [ClientController::class, 'insertRoles'])->name('insert_roles');
        Route::post('insert-permission/{id}', [ClientController::class, 'insertPermission'])->name('insert_permission');
        Route::post('insert-permission/', [ClientController::class, 'insertPerPermission'])->name('insert_per_permission');
        Route::get('impersonate/user/{id}', [ClientController::class, 'impersonate'])->name('impersonate');
    });
});
Route::get('posts/detail/{id}', [BlogController::class, 'show'])->name('posts.detail');
Route::post('comment/{blog_id}', [BlogController::class, 'comment'])->name('posts.comment');
Route::get('posts/add', [BlogController::class, 'add'])->name('posts.add');
Route::post('blogs/store', [BlogController::class, 'store'])->name('blogs.store');

Route::get('blogs/index', [BlogController::class, 'index'])->name('blogs.index');



