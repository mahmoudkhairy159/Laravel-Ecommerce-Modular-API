<?php

use Illuminate\Support\Facades\Route;
use Modules\Item\App\Http\Controllers\Api\ItemController;
use Modules\Item\App\Http\Controllers\Api\ItemImageController;
use Modules\Item\App\Http\Controllers\Api\RelatedItemController;

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

    // items routes
    Route::apiResource('items', ItemController::class)->only(['index', 'show']);
    // items routes

    // item-images routes
    Route::controller(ItemImageController::class)->prefix('item-images')->as('item-images.')->group(function () {
        Route::get('/item/{id}', 'getByItemId')->name('getByItemId');
    });
    Route::apiResource('item-images', ItemImageController::class)->only(['show']);
    // item-images routes
      // related-items routes
      Route::controller(RelatedItemController::class)->prefix('related-items')->as('related-items.')->group(function () {
        Route::get('/item/{id}', 'getRelatedItems')->name('getRelatedItems');
    });
    // related-items routes
});
