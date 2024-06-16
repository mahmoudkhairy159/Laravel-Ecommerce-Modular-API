<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Area\App\Http\Controllers\Admin\CountryController;
use Modules\Area\App\Http\Controllers\Admin\CityController;

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



    // Countries routes
    /***********Trashed Countries SoftDeletes**************/
    Route::controller(CountryController::class)->prefix('countries')->as('countries.')->group(function () {
        Route::get('/trashed', 'getOnlyTrashed')->name('getOnlyTrashed');
        Route::delete('/force-delete/{id}', 'forceDelete')->name('forceDelete');
        Route::post('/restore/{id}', 'restore')->name('restore');
    });
    /***********Trashed Countries SoftDeletes**************/
    Route::apiResource('countries', CountryController::class);
    // Countries routes

    // Cities routes
    Route::get('/cities/getByCountryId/{country_id}', [CityController::class, 'getByCountryId'])->name('cities.getByCountryId');
    /***********Trashed Cities SoftDeletes**************/
    Route::controller(CityController::class)->prefix('cities')->as('cities.')->group(function () {
        Route::get('/trashed', 'getOnlyTrashed')->name('getOnlyTrashed');
        Route::delete('/force-delete/{id}', 'forceDelete')->name('forceDelete');
        Route::post('/restore/{id}', 'restore')->name('restore');
    });
    /***********Trashed Cities SoftDeletes**************/
    Route::apiResource('cities', CityController::class);
    // Cities routes

});
