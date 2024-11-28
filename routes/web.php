<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes([
    'register' => false,
    'reset' => false,
    ]);
    
Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [BukuController::class, 'index']);

Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');

Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');

Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');

Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');






Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::delete('/buku/{buku}/gallery/{gallery}', [BukuController::class, 'deleteGalleryImage'])->name('buku.deleteGalleryImage');

/* Route::middleware(['auth', 'role:internal_reviewer,administrator'])->group(function () {
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
}); */

Route::get('/reviewer/{id}', [ReviewController::class, 'byReviewer'])->name('reviews.byReviewer');
Route::get('/tag/{name}', [ReviewController::class, 'byTag'])->name('reviews.byTag');

// Route untuk menampilkan form review
Route::get('/buku/{bookId}/review/create', [ReviewController::class, 'create'])->name('review.create');

// Route untuk menyimpan review
Route::post('buku/{bookId}/review', [ReviewController::class, 'store'])->name('review.store');

// Rute untuk menampilkan review berdasarkan reviewer
Route::get('reviews/reviewer/{userId}', [ReviewController::class, 'reviewsByReviewer'])->name('reviews.byReviewer');

// Rute untuk menampilkan review berdasarkan tag
Route::get('reviews/tag/{tagId}', [ReviewController::class, 'reviewsByTag'])->name('reviews.byTag');



