<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LocationLookupController;
use App\Http\Controllers\UserController;
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

Route::post('user/register', [RegisterController::class, 'register'])->name('api.auth.register');
Route::post('user/login', [LoginController::class, 'apiLogin'])->name('api.auth.login');

// Password Reset
Route::post('forgot-password', [ForgotPasswordController::class, 'resetPassword'])
    ->middleware(['guest'])->name('api.password.email');
Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])
    ->middleware(['guest'])->name('api.password.update');

// Email Verification
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'apiEmailVerification'])->name('api.verification.verify');

// Not Authenticated
    Route::get('company/{company}', [CompanyController::class, 'show'])->name('api.company.show');
    Route::get('job/{job:slug}', [JobController::class, 'show'])->name('api.job.show');

// Lookups
Route::prefix('lookup')->group(function () {
    Route::post('{location}', [LocationLookupController::class, 'index'])->name('api.lookup.location');
});

Route::middleware('auth:sanctum')->group(function () {
    //Authenticated
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('api.auth.user');
        Route::post('logout', [LoginController::class, 'apiLogout'])->name('api.auth.logout');
        Route::patch('profile', [UserController::class, 'update'])->name('api.user.update');
    });

    // Company
    Route::prefix('company')->group(function () {
        Route::post('/', [CompanyController::class, 'store'])->name('api.company.store');
        Route::patch('{company}', [CompanyController::class, 'update'])->name('api.company.update')->middleware('can:update,company');
        Route::delete('{company}', [CompanyController::class, 'destroy'])->name('api.company.destroy')->middleware('can:delete,company');
    });

    // Job
    Route::resource('job', JobController::class)->except(['index', 'show']);
});
