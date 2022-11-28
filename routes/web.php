<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\GoogleController;
use App\Http\Controllers\API\MultipleImagePostController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('google/')->name('google.')->group( function(){
    Route::get('login', [GoogleController::class, 'login'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackGoogle'])->name('callback');
});

