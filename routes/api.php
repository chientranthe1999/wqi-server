<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InforController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return response()->json(['status' => 'api ready!']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// TODO: Handle authen api failure
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'userDetail']);

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/disable/{id}', [UserController::class, 'disable']);
        Route::put('/active/{id}', [UserController::class, 'active']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        // Route::put('/{id}', [DeviceController::class, 'update']);
        // Route::delete('/{id}', [DeviceController::class, 'destroy']);
    });

    Route::prefix('devices')->group(function () {
        Route::get('/', [DeviceController::class, 'index']);
        Route::post('/', [DeviceController::class, 'store']);
        Route::get('/{id}', [DeviceController::class, 'show']);
        Route::put('/{id}', [DeviceController::class, 'update']);
        Route::delete('/{id}', [DeviceController::class, 'destroy']);
    });

    Route::prefix('articles')->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::post('/', [ArticleController::class, 'store']);
        Route::get('/{id}', [ArticleController::class, 'show']);
        Route::put('/{id}', [ArticleController::class, 'update']);
        Route::delete('/{id}', [ArticleController::class, 'destroy']);
    });

    Route::get('/dashboard', [InforController::class, 'dashboard']);
});

Route::prefix('infors')->group(function () {
    Route::get('/', [InforController::class, 'index']);
    Route::post('/', [InforController::class, 'store']);
    Route::get('/{id}', [InforController::class, 'show']);
    Route::put('/{id}', [InforController::class, 'update']);
    Route::delete('/{id}', [InforController::class, 'destroy']);
});
