<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/articles/create', [UserController::class, 'create'])->name('articles.create');
Route::post('/articles/store', [UserController::class, 'store'])->name('articles.store');