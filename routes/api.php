<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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

Route::name('account.')->prefix('account')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/', [AuthController::class, 'index'])->middleware('auth:sanctum');
});


Route::name('homes.')->prefix('homes')->middleware('auth:sanctum')->group(function () {
    Route::post('/budget', [HomeController::class, 'budget']);
    Route::post('/sqft', [HomeController::class, 'sqft']);
    Route::post('/age', [HomeController::class, 'age']);
    Route::post('/standard_price', [HomeController::class, 'standardPrice']);
});
