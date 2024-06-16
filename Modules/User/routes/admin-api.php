<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\Admin\FollowsController;
use Modules\User\App\Http\Controllers\Admin\UserController;

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


    // Users routes
    Route::get('/users/slugs/{slug}', [UserController::class,'showBySlug'])->name('users.showBySlug');
    Route::apiResource('users', UserController::class);
    // Users routes

});
