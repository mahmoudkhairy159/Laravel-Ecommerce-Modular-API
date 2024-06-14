<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Category\App\Http\Controllers\Admin\CategoryController;

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

    //categories routes
    /***********Trashed event-categories SoftDeletes**************/
    Route::controller(CategoryController::class)->prefix('categories')->as('categories.')->group(function () {
        Route::get('trashed', 'getOnlyTrashed')->name('getOnlyTrashed');
        Route::delete('force-delete/{id}', 'forceDelete')->name('forceDelete');
        Route::post('restore/{id}', 'restore')->name('restore');
    });
    /***********Trashed categories SoftDeletes**************/
    Route::apiResource('categories',CategoryController::class);
    //categories routes


});
