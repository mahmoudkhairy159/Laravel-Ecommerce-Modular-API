<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\App\Http\Controllers\Admin\ReviewController;

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




    // reviews routes
    /***********Trashed reviews SoftDeletes**************/
    Route::controller(ReviewController::class)->prefix('reviews')->as('reviews.')->group(function () {
        Route::get('/trashed', 'getOnlyTrashed')->name('getOnlyTrashed');
        Route::delete('/force-delete/{id}', 'forceDelete')->name('forceDelete');
        Route::post('/restore/{id}', 'restore')->name('restore');
    });
    /***********Trashed reviews SoftDeletes**************/
    Route::controller(ReviewController::class)->name('reviews.')->prefix('/reviews')->group(function () {
        Route::get('/item/{item_id}', 'getByItemId')->name('getByItemId');
        Route::get('/user/{user_id}', 'getByUserId')->name('getByUserId');
    });
    Route::apiResource('reviews', ReviewController::class)->only(['show', 'destroy']);
    // reviews routes


});
