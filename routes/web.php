<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('accueil');

Route::get('/tableau-de-bord', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/mon-compte', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mon-compte', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/mon-compte', [ProfileController::class, 'effacerCompte'])->name('profile.supprimer');

    Route::get('/mes-articles', [UserController::class, 'show'])->name('articles.index');
    Route::get('/ecrire-un-article', [UserController::class, 'create'])->name('articles.create');
    Route::post('/enregistrer-article', [UserController::class, 'store'])->name('articles.store');
    Route::get('/modifier-article/{article}', [UserController::class, 'edit'])->name('articles.edit');
    Route::put('/maj-article/{article}', [UserController::class, 'update'])->name('articles.update');
    Route::delete('/supprimer-article/{article}', [UserController::class, 'supprimerArticle'])->name('articles.delete');
    Route::post('/commenter/{article}', [UserController::class, 'publierCommentaire'])->name('commentaires.publier');
    Route::post('/aimer/{article}', [UserController::class, 'aimerArticle'])->name('articles.aimer');
    Route::delete('/retirer-commentaire/{comment}', [UserController::class, 'supprimerCommentaire'])->name('commentaires.supprimer');

    Route::post('/suivre/{user}', [UserController::class, 'suivreAuteur'])->name('auteurs.suivre');

    Route::post('/notifications/marquer-lu', function() {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');

    Route::get('/gestion-categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/nouvelle-categorie', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/creer-categorie', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/modifier-categorie/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/maj-categorie/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/supprimer-categorie/{category}', [CategoryController::class, 'supprimer'])->name('categories.delete');

    Route::get('/gestion-tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('/nouveau-tag', [TagController::class, 'create'])->name('tags.create');
    Route::post('/creer-tag', [TagController::class, 'store'])->name('tags.store');
    Route::get('/modifier-tag/{tag}', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/maj-tag/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/supprimer-tag/{tag}', [TagController::class, 'supprimer'])->name('tags.delete');
});

require __DIR__.'/auth.php';

Route::get('/auteurs', [PublicController::class, 'listeAuteurs'])->name('auteurs.index');
Route::get('/profil/{user}', [PublicController::class, 'profilAuteur'])->name('auteurs.profil');
Route::get('/archives', [PublicController::class, 'rechercherArticles'])->name('articles.archives');
Route::get('/blog/{user}', [PublicController::class, 'index'])->name('blog.index');
Route::get('/blog/{user}/{article}', [PublicController::class, 'show'])->name('blog.article');

