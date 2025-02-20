<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProfileController;
use App\Livewire\SeleccionAlbum;
use App\Models\Album;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('albumes.index',[
        'albumes' => Album::paginate(2),
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('albumes', AlbumController::class)->parameters([
    'albumes' => 'album'  // Forzar el uso de "album" en lugar de "albume"
]);





require __DIR__.'/auth.php';
