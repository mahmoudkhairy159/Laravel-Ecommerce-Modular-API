<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Brand\App\Http\Controllers\Admin\BrandController;

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

    //brands routes
    /***********Trashed brands SoftDeletes**************/
    Route::controller(BrandController::class)->prefix('brands')->as('brands.')->group(function () {
        Route::get('trashed', 'getOnlyTrashed')->name('getOnlyTrashed');
        Route::delete('force-delete/{id}', 'forceDelete')->name('forceDelete');
        Route::post('restore/{id}', 'restore')->name('restore');
    });
    /***********Trashed brands SoftDeletes**************/
    Route::apiResource('brands',BrandController::class);
    //brands routes


});
