<?php

use App\Http\Controllers\AuthControler;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthControler::class, 'logout']);
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('exercises', [ExerciseController::class, 'index']);
    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::delete('exercises/{id}', [ExerciseController::class, 'destroy']);

    Route::post('students', [StudentController::class, 'store'])->middleware('check.student.limit');
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    Route::put('students/{id}', [StudentController::class, 'update']);
    Route::get('students', [StudentController::class, 'index']);
    Route::get('students/{id}', [StudentController::class, 'show']);

    Route::post('workouts', [WorkoutController::class, 'store']);
    Route::get('students/{id}/workouts', [WorkoutController::class, 'getWorkouts']);

    Route::get('students/{id}/export', [WorkoutController::class, 'exportPDF']);


});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthControler::class, 'store']);
