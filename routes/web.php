<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;
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


Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');
Route::get('/videos/test', [VideosController::class, 'testedBy'])->name('videos.testedBy');

use App\Http\Controllers\VideoController;
use App\Http\Controllers\AboutController;

// Ruta per a la pàgina de vídeos (llistat de vídeos)
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');

// Ruta per a la pàgina About
Route::get('/about', [AboutController::class, 'index'])->name('about');
