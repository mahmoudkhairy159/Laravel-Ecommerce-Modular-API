<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Payment\App\Http\Controllers\Api\UserPaymentController;
use Modules\User\App\Http\Controllers\Api\Auth\LoginController;
use Modules\User\App\Http\Controllers\Api\Auth\RegisterController;
use Modules\User\App\Http\Controllers\Api\Auth\VerificationController;
use Modules\User\App\Http\Controllers\Api\Auth\ResetPasswordController;
use Modules\User\App\Http\Controllers\Api\Auth\ForgotPasswordController;
use Modules\User\App\Http\Controllers\Api\Auth\LogoutController;
use Modules\User\App\Http\Controllers\Api\FollowsController;
use Modules\User\App\Http\Controllers\Api\UserController;

// /*
//     |--------------------------------------------------------------------------
//     | API Routes
//     |--------------------------------------------------------------------------
//     |
//     | Here is where you can register API routes for your application. These
//     | routes are loaded by the RouteServiceProvider within a group which
//     | is assigned the "api" middleware group. Enjoy building your API!
//     |
// */


Route::prefix('v1')->name('user-api.')->group(function () {
     // user-payments routes
     Route::controller(UserPaymentController::class)->prefix('user-payments')->as('user-payments.')->group(function () {
        Route::get('/my-payments', 'getMyPayments')->name('getMyPayments');

    });
    Route::apiResource('user-payments', UserPaymentController::class)->except(['index']);
    // user-payments routes

});
