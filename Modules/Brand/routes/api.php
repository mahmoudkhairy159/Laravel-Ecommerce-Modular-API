<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Brand\App\Http\Controllers\Api\BrandController;

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

    //brands routes
    Route::apiResource('brands', BrandController::class)->only(['index', 'show']);
    //brands routes







});
