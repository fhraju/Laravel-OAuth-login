<?php

use App\Http\Controllers\GoogleController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Login with Google
Route::prefix('google')->name('google.')->group( function()
{
    Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
    Route::get('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
});