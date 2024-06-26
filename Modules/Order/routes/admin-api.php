<?php

use Illuminate\Support\Facades\Route;

use Modules\Order\App\Http\Controllers\Admin\OrderController;
use Modules\Order\App\Http\Controllers\Admin\OrderHistoryController;
use Modules\Order\App\Http\Controllers\Admin\OrderItemController;
use Modules\Order\App\Http\Controllers\Admin\OrderShippingInformationController;

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


    // orders routes
    Route::controller(OrderController::class)->prefix('orders')->as('orders.')->group(function () {
        Route::get('/user/{id}', 'getByUserId')->name('getByUserId');
        Route::put('/user/{id}/change-status', 'changeStatus')->name('changeStatus');
    });
    Route::apiResource('orders', OrderController::class);
    // orders routes

    //order-histories
    Route::controller(OrderHistoryController::class)->prefix('order-histories')->as('order-histories.')->group(function () {
        Route::get('/order/{id}', 'getByOrderId')->name('getByOrderId');
    });
    Route::apiResource('order-histories', OrderHistoryController::class)->except(['index']);
    //order-histories

    //order-items
    Route::controller(OrderItemController::class)->prefix('order-items')->as('order-items.')->group(function () {
        Route::get('/order/{id}', 'getByOrderId')->name('getByOrderId');
    });
    Route::apiResource('order-items', OrderItemController::class)->except(['index']);
    //order-items
     //order-shipping-information
     Route::controller(OrderShippingInformationController::class)->prefix('order-shipping-information')->as('order-shipping-information.')->group(function () {
        Route::get('/order/{id}', 'getByOrderId')->name('getByOrderId');
    });
    Route::apiResource('order-shipping-information', OrderShippingInformationController::class)->except(['index']);
    //order-shipping-information



});
