<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\App\Http\Controllers\Api\OrderController;
use Modules\Order\App\Http\Controllers\Api\OrderHistoryController;
use Modules\Order\App\Http\Controllers\Api\OrderItemController;
use Modules\Order\App\Http\Controllers\Api\OrderShippingInformationController;

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

    // orders routes
    Route::apiResource('orders', OrderController::class);
    // orders routes

    //order-histories
    Route::controller(OrderHistoryController::class)->prefix('order-histories')->as('order-histories.')->group(function () {
        Route::get('/order/{id}', 'getByOrderId')->name('getByOrderId');
    });
    //order-histories

    //order-items
    Route::controller(OrderItemController::class)->prefix('order-items')->as('order-items.')->group(function () {
        Route::get('/order/{id}', 'getByOrderId')->name('getByOrderId');
    });
    Route::apiResource('order-items', OrderItemController::class)->only(['update', 'destroy']);
    //order-items
     //order-shipping-information
     Route::controller(OrderShippingInformationController::class)->prefix('order-shipping-information')->as('order-shipping-information.')->group(function () {
        Route::get('/order/{id}', 'getByOrderId')->name('getByOrderId');
    });
    Route::apiResource('order-shipping-information', OrderShippingInformationController::class)->only(['update', 'destroy']);
});
