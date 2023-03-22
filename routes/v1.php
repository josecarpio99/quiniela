<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\GameController;
use App\Http\Controllers\Api\Admin\TeamController;
use App\Http\Controllers\Api\Admin\DepositController;
use App\Http\Controllers\Api\Admin\QuinielaController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::apiResource('game', GameController::class);
        Route::apiResource('team', TeamController::class);
        Route::apiResource('quiniela', QuinielaController::class);

        Route::apiResource('deposit', DepositController::class)->except('show', 'update', 'destroy');
        Route::get('deposit/{transaction}', [DepositController::class, 'show'])->name('deposit.show');
        Route::put('deposit/{transaction}', [DepositController::class, 'update'])->name('deposit.update');
        Route::delete('deposit/{transaction}', [DepositController::class, 'destroy'])->name('deposit.destroy');
    });
});
