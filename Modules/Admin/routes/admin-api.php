<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\Admin\AdminController;
use Modules\Admin\App\Http\Controllers\Admin\Auth\AuthController;
use Modules\Admin\App\Http\Controllers\Admin\PermissionController;
use Modules\Admin\App\Http\Controllers\Admin\RoleController;

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
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/refresh-token', 'refresh')->name('refresh-token');
        Route::post('/update-info', 'update')->name('update-info');
        Route::get('/get-info', 'get')->name('get-info');
    });
    // Auth routes


    // Permissions routes
    Route::controller(PermissionController::class)->name('permissions.')->prefix('/permissions')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    // Permissions routes


    // Roles routes
    Route::apiResource('roles',RoleController::class);
    // Roles routes


    // Admins routes
    Route::apiResource('admins',AdminController::class);
    // Admins routes

});
