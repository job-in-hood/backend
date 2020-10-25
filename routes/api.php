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

// Password Reset
Route::post('forgot-password', 'Auth\ForgotPasswordController@resetPassword')
    ->middleware(['guest'])->name('api.password.email');
Route::post('reset-password', 'Auth\ForgotPasswordController@updatePassword')
    ->middleware(['guest'])->name('api.password.update');

// Email Verification
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@apiEmailVerification')->name('api.verification.verify');

// Not Authenticated
Route::prefix('company')->group(function () {
    Route::get('{company}', 'CompanyController@show')->name('api.company.show');
});

Route::middleware('auth:sanctum')->group(function () {
    //Authenticated
    Route::prefix('user')->group(function () {
        Route::post('logout', 'Auth\LoginController@apiLogout')->name('api.auth.logout');
        Route::get('/', 'Auth\LoginController@apiGetCurrentUser')->name('api.auth.user');
    });

    Route::prefix('company')->group(function () {
        Route::put('/', 'CompanyController@store')->name('api.company.store');
//        Route::post('/', 'Auth\LoginController@apiGetCurrentUser')->name('api.auth.user');
    });
});
