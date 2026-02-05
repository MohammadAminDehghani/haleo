<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('todos', TodoController::class);
    Route::apiResource('activities', ActivityController::class);
    Route::apiResource('users', UserController::class);
});

