<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\App\Http\Controllers\Admin\CartController;
use Modules\Cart\App\Http\Controllers\Admin\DiscountController;

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




    // cart routes
    Route::controller(CartController::class)->name('carts.')->prefix('carts')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/user/{userId}', 'viewUserCart')->name('viewUserCart');
        Route::put('/user/{userId}', 'updateUserCart')->name('updateUserCart');
    });
    // cart routes


});
