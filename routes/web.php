<?php

use App\Http\Controllers\VideoManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AboutController;
Route::get('/', function () {
    return view('welcome');
});
// Ruta per a la pàgina About
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
// Ruta per a la pàgina de vídeos (llistat de vídeos)
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');

Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');

Route::middleware(['auth'])->group(function () {
    Route::get('videos/{video}/edit', [VideoController::class, 'edit'])
        ->middleware('can:edit videos,video') // Assegura't que la política coincideix amb el mètode
        ->name('videos.edit');
});
Route::middleware(['can:manage-videos'])->group(function () {
    Route::get('/videoscreate', [VideoManageController::class, 'create'])->name('videos.create');
    Route::put('/videos/{video}', [VideoManageController::class, 'update'])->name('videos.update');
    Route::post('/videos', [VideoManageController::class, 'store'])->name('videos.store');
    Route::get('/videos/{video}/delete', [VideoManageController::class, 'delete'])->name('videos.delete');
    Route::delete('/videos/{video}', [VideoManageController::class, 'destroy'])->name('videos.destroy');
});

Route::get('/videos/test', [VideoController::class, 'testedBy'])->name('videos.testedBy');
//Route::resource('videos', VideoController::class);
