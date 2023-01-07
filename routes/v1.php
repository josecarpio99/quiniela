<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\TeamController;

Route::apiResource('team', TeamController::class);
Route::apiResource('game', GameController::class);