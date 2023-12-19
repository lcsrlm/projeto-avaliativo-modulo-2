<?php

use App\Http\Controllers\AuthControler;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthControler::class, 'store']);
