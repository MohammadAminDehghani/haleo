<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('articles', ArticleController::class);
Route::apiResource('todos', TodoController::class);
Route::apiResource('activities', ActivityController::class);
Route::apiResource('users', UserController::class);

