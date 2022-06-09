<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

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
Route::get('', function () {
    return response()->json(['status' => 'api ready!']);
});

Route::prefix('cars')->group(function () {
    Route::get('', [CarController::class, 'index']);
    Route::post('', [CarController::class, 'store']);
});

Route::prefix('parts')->group(function () {
    Route::get('', [PartController::class, 'index']);
    Route::post('', [PartController::class, 'store']);
});

Route::prefix('companies')->group(function () {
    Route::get('', [CompanyController::class, 'index']);
    Route::post('', [CompanyController::class, 'store']);
});

Route::prefix('providers')->group(function () {
    Route::get('', [ProviderController::class, 'index']);
    Route::post('', [ProviderController::class, 'store']);
});

