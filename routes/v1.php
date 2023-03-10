<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\QuinielaController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('game', GameController::class);
    Route::apiResource('team', TeamController::class);
    Route::apiResource('quiniela', QuinielaController::class);
});
