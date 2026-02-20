<?php

use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes API - Dashboard Unity 3D
| Préfixe automatique : /api/...
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/stats', [StatsController::class, 'index']);
        Route::get('/stats/articles', [StatsController::class, 'articles']);
        Route::get('/stats/comments', [StatsController::class, 'comments']);
        Route::get('/stats/users', [StatsController::class, 'users']);
        Route::get('/stats/activity', [StatsController::class, 'activity']);

        Route::get('/articles', [ArticleController::class, 'index']);
        Route::get('/articles/{article:slug}', [ArticleController::class, 'show']);
        Route::get('/articles/top', [ArticleController::class, 'top']);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);

        Route::get('/comments/latest', [CommentController::class, 'latest']);
    });



});

