<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Area\App\Http\Controllers\Api\CountryController;
use Modules\Area\App\Http\Controllers\Api\CityController;

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

Route::prefix('v1')->name('user-api.')->group(function () {

    // Countries routes
    Route::apiResource('countries', CountryController::class)->only(['index', 'show']);
    // Countries routes


    // Cities routes
    Route::controller(CityController::class)->name('cities.')->prefix('/cities')->group(function () {
        Route::get('/country/{country_id}', 'getByCountryId')->name('getByCountryId');
        Route::get('/{id}', 'show')->name('show');
    });
    // Cities routes
});
