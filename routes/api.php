<?php

use App\Http\Controllers\AuthControler;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthControler::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/exercises', [ExerciseController::class, 'store']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthControler::class, 'store']);
