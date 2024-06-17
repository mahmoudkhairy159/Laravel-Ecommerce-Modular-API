<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Payment\App\Http\Controllers\Admin\UserPaymentController;


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

Route::prefix('v1')->name('admin-api.')->group(function () {


    // user-payments routes
    Route::controller(UserPaymentController::class)->prefix('user-payments')->as('user-payments.')->group(function () {
        Route::get('/user/{id}', 'getByUserId')->name('getByUserId');

    });
    Route::apiResource('user-payments', UserPaymentController::class);
    // user-payments routes

});
