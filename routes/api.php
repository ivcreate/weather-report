<?php

use App\Http\Controllers\Api\Public\TrackedLocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'tracked-locations'], function () {
    Route::get('/', [TrackedLocationController::class, 'index']);
    Route::post('/', [TrackedLocationController::class, 'store']);
    Route::get('/{id}', [TrackedLocationController::class, 'show']);
    Route::put('/{id}', [TrackedLocationController::class, 'update']);
    Route::delete('/{id}', [TrackedLocationController::class, 'destroy']);
});
