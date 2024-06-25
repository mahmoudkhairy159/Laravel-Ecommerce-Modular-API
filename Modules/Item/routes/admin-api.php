<?php

use Illuminate\Support\Facades\Route;
use Modules\Item\App\Http\Controllers\Admin\ItemController;
use Modules\Item\App\Http\Controllers\Admin\ItemImageController;
use Modules\Item\App\Http\Controllers\Admin\RelatedItemController;

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


    // items routes
    Route::apiResource('items', ItemController::class);
    // items routes

    // item-images routes
    Route::controller(ItemImageController::class)->prefix('item-images')->as('item-images.')->group(function () {
        Route::get('/item/{id}', 'getByItemId')->name('getByItemId');
    });
    Route::apiResource('item-images', ItemImageController::class)->except(['index']);
    // item-images routes

    // related-items routes
    Route::controller(RelatedItemController::class)->prefix('related-items')->as('related-items.')->group(function () {
        Route::get('/item/{id}', 'getRelatedItems')->name('getRelatedItems');
    });
    Route::apiResource('related-items', RelatedItemController::class)
        ->only(['store', 'update', 'destroy']);
    // related-items routes

});
