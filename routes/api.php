<?php

use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TagsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes API - Client lourd C# Dotnet MAUI MudBrazor
| Préfixe automatique : /api/v1/...
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
        Route::get('/articles/top', [ArticleController::class, 'top']);
        Route::get('/articles/{article:slug}', [ArticleController::class, 'show']);
        Route::delete('/articles/{article:id}', [ArticleController::class, 'destroy']);

        Route::get('/authors', [ArticleController::class, 'authors']);
        Route::get('/authors/{user}/articles', [ArticleController::class, 'authors_articles']);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::get('/show_users', [UserController::class, 'show_users']);
        Route::delete('/del_user/{user:id}', [UserController::class, 'destroy']);

        Route::get('/comments/latest', [CommentController::class, 'latest']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

        Route::get('/category', [CategoryController::class, 'index']);
        Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

        Route::get('/tags', [TagsController::class, 'index']);
        Route::delete('/tags/{tag}', [TagsController::class, 'destroy']);
    });

});

