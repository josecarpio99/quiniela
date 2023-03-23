<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\GameController;
use App\Http\Controllers\Api\Admin\TeamController;
use App\Http\Controllers\Api\Admin\TicketController;
use App\Http\Controllers\Api\Admin\DepositController;
use App\Http\Controllers\Api\Admin\QuinielaController;
use App\Http\Controllers\Api\Admin\WithdrawController;
use App\Http\Controllers\Api\Admin\PaymentMethodController;
use App\Http\Controllers\Api\Admin\ChangeDepositStatusController;
use App\Http\Controllers\Api\Admin\ChangeWithdrawStatusController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::apiResource('game', GameController::class);
        Route::apiResource('team', TeamController::class);
        Route::apiResource('quiniela', QuinielaController::class);
        Route::apiResource('deposit', DepositController::class);
        Route::apiResource('withdraw', WithdrawController::class);
        Route::apiResource('payment_method', PaymentMethodController::class);

        Route::scopeBindings()->group(function() {
            Route::apiResource('quiniela.ticket', TicketController::class);
        });

        Route::post('deposit/{deposit}/status', ChangeDepositStatusController::class);
        Route::post('withdraw/{withdraw}/status', ChangeWithdrawStatusController::class);
    });
});
