<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\AdminsController;
use Modules\Admin\App\Http\Controllers\AuthController;
use Modules\Admin\App\Http\Controllers\PermissionsController;
use Modules\Admin\App\Http\Controllers\RolesController;

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
    // Auth routes
    Route::controller(AuthController::class)->name('auth.')->prefix('/auth')->group(function () {
        Route::post('/login', 'create')->name('login');
        Route::post('/logout', 'destroy')->name('logout');
        Route::post('/refresh-token', 'refresh')->name('refresh-token');
        Route::post('/update-info', 'update')->name('update-info');
        Route::get('/get-info', 'get')->name('get-info');
    });
    // Auth routes


    // Permissions routes
    Route::controller(PermissionsController::class)->name('permissions.')->prefix('/permissions')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    // Permissions routes


    // Roles routes
    Route::apiResource('roles',RolesController::class);
    // Roles routes


    // Admins routes
    Route::apiResource('admins',AdminsController::class);
    // Admins routes

});
