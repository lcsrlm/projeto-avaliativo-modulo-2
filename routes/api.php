<?php

use App\Http\Controllers\AuthControler;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum', 'check.student.limit')->group(function () {
    Route::post('logout', [AuthControler::class, 'logout']);
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

    Route::post('/students', [StudentController::class, 'store']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthControler::class, 'store']);
