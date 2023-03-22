<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\GameController;
use App\Http\Controllers\Api\Admin\TeamController;
use App\Http\Controllers\Api\Admin\DepositController;
use App\Http\Controllers\Api\Admin\QuinielaController;
use App\Http\Controllers\Api\Admin\WithdrawController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::apiResource('game', GameController::class);
        Route::apiResource('team', TeamController::class);
        Route::apiResource('quiniela', QuinielaController::class);

        Route::get('deposit', [DepositController::class, 'index'])->name('deposit.index');
        Route::get('user/{user}/deposit/{transaction}', [DepositController::class, 'show'])->name('deposit.show');
        Route::post('user/{user}/deposit', [DepositController::class, 'store'])->name('deposit.store');
        Route::put('user/{user}/deposit/{transaction}', [DepositController::class, 'update'])->name('deposit.update');
        Route::delete('user/{user}/deposit/{transaction}', [DepositController::class, 'destroy'])->name('deposit.destroy');

        Route::get('withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
        Route::get('user/{user}/withdraw/{transaction}', [WithdrawController::class, 'show'])->name('withdraw.show');
        Route::post('user/{user}/withdraw', [WithdrawController::class, 'store'])->name('withdraw.store');
        Route::put('user/{user}/withdraw/{transaction}', [WithdrawController::class, 'update'])->name('withdraw.update');
        Route::delete('user/{user}/withdraw/{transaction}', [WithdrawController::class, 'destroy'])->name('withdraw.destroy');
    });
});
