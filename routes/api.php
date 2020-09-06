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
    Route::prefix('user')->group(function () {
        Route::post('logout', 'Auth\LoginController@apiLogout')->name('api.auth.logout');
        Route::get('/', 'Auth\LoginController@apiGetCurrentUser')->name('api.auth.user');
    });

    Route::prefix('company')->group(function () {
        Route::put('/', 'CompanyController@store')->name('api.company.store');
//        Route::post('/', 'Auth\LoginController@apiGetCurrentUser')->name('api.auth.user');
    });
});
