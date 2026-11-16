<?php

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::get('/articles', [ArticleApiController::class, 'index']);
Route::get('/articles/{article}', [ArticleApiController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::post('/articles', [ArticleApiController::class, 'store']);
    Route::put('/articles/{article}', [ArticleApiController::class, 'update']);
    Route::patch('/articles/{article}', [ArticleApiController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleApiController::class, 'destroy']);
});
