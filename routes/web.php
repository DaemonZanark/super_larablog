<?php



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/articles', [UserController::class, 'show'])->name('articles.show');

Route::get('/articles/create', [UserController::class, 'create'])->name('articles.create');
Route::post('/articles/store', [UserController::class, 'store'])->name('articles.store');

Route::get('articles/{article}/edit', [UserController::class, 'edit'])->name('articles.edit');
Route::post('articles/{article}/update', [UserController::class, 'update'])->name('articles.update');

require __DIR__.'/auth.php';
