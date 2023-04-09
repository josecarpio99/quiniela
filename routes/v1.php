<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\GameController;
use App\Http\Controllers\Api\Admin\TeamController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\TicketController;
use App\Http\Controllers\Api\Admin\DepositController;
use App\Http\Controllers\Api\Admin\QuinielaController;
use App\Http\Controllers\Api\Admin\WithdrawController;
use App\Http\Controllers\Api\Admin\PaymentMethodController;
use App\Http\Controllers\Api\Admin\BalanceHistoryController;
use App\Http\Controllers\Api\Admin\UpdateUserBalanceController;
use App\Http\Controllers\Api\Admin\ChangeDepositStatusController;
use App\Http\Controllers\Api\Admin\UpdateTicketsPointsController;
use App\Http\Controllers\Api\Admin\UpdateTicketsStatusController;
use App\Http\Controllers\Api\Admin\ChangeWithdrawStatusController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::apiResource('user', UserController::class);
        Route::get('user/{user}/balance_history', BalanceHistoryController::class);

        Route::apiResource('game', GameController::class);
        Route::apiResource('team', TeamController::class);
        Route::apiResource('quiniela', QuinielaController::class);
        Route::apiResource('deposit', DepositController::class);
        Route::apiResource('withdraw', WithdrawController::class);
        Route::apiResource('payment_method', PaymentMethodController::class);

        Route::scopeBindings()->group(function() {
            Route::apiResource('quiniela.ticket', TicketController::class);
        });
        Route::post('quiniela/{quiniela}/ticket/update_points', UpdateTicketsPointsController::class)->name('ticket.update_points');
        Route::post('quiniela/{quiniela}/ticket/update_status', UpdateTicketsStatusController::class)->name('ticket.update_status');

        Route::post('deposit/{deposit}/status', ChangeDepositStatusController::class);
        Route::post('withdraw/{withdraw}/status', ChangeWithdrawStatusController::class);
        Route::put('user/{user}/update_balance', UpdateUserBalanceController::class);
    });

    Route::get('profile/{user}', [App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::put('profile/{user}', [App\Http\Controllers\Api\ProfileController::class, 'update']);

    Route::get('deposit', [App\Http\Controllers\Api\DepositController::class, 'index']);
    Route::post('deposit', [App\Http\Controllers\Api\DepositController::class, 'store']);
    Route::get('deposit/{deposit}', [App\Http\Controllers\Api\DepositController::class, 'show']);

    Route::get('withdraw', [App\Http\Controllers\Api\WithdrawController::class, 'index']);
    Route::post('withdraw', [App\Http\Controllers\Api\WithdrawController::class, 'store']);
    Route::get('withdraw/{deposit}', [App\Http\Controllers\Api\WithdrawController::class, 'show']);

    Route::get('quiniela/{quiniela}/ticket', [App\Http\Controllers\Api\TicketController::class, 'index']);
    Route::post('quiniela/{quiniela}/ticket', [App\Http\Controllers\Api\TicketController::class, 'store']);
    Route::get('quiniela/{quiniela}/ticket/{ticket}', [App\Http\Controllers\Api\TicketController::class, 'show']);
    Route::put('quiniela/{quiniela}/ticket/{ticket}', [App\Http\Controllers\Api\TicketController::class, 'update']);
});
