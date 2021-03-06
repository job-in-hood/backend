<?php

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
    return view('index');
})->name('home');

//Route::get('test', function () {
//   return Storage::disk('azure')->download('test/example.txt');
//});

//Route::prefix('email')->group(function() {
//    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//    Route::post('login', 'Auth\LoginController@login');
//});

//Auth::routes([
//    'login' => false,
//    'logout' => false,
//    'register' => false,
//    'verify' => true,
//]);


//Route::get('/home', 'HomeController@index')->name('home');

//Route::get('reset-password', function () {
//})->middleware(['guest'])->name('password.reset');
//
Route::get('email/verify/{id}/{hash}', function() {
    return null;
})->name('verification.verify');

