<?php

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


Route::post('user/register', 'Auth\RegisterController@register')->name('api.auth.register');
Route::post('user/login', 'Auth\LoginController@apiLogin')->name('api.auth.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/logout', 'Auth\LoginController@apiLogout')->name('api.auth.logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
