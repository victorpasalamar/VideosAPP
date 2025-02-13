<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AboutController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::middleware(['auth', 'can:edit-videos,video'])->group(function () {
    Route::get('videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
});
Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/videos/test', [VideoController::class, 'testedBy'])->name('videos.testedBy');
// Ruta per a la pàgina de vídeos (llistat de vídeos)
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');

Route::resource('videos', VideoController::class);

// Ruta per a la pàgina About
Route::get('/about', [AboutController::class, 'index'])->name('about');
