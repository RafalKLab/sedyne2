<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard.welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/spaces', [SpaceController::class, 'index'])->name('spaces');
    Route::post('/spaces', [SpaceController::class, 'storeSpace']);

    Route::get('/spaces/{id}/layout', [SpaceController::class, 'setupLayout'])->name('setup-layout');
    Route::post('/spaces/{id}/layout', [SpaceController::class, 'saveLayout']);

    Route::get('/spaces/{id}/preview', [SpaceController::class, 'previewSpace'])->name('space-preview');

    Route::post('/spaces/{id}/set-primary', [SpaceController::class, 'setPrimary'])->name('space-set-primary');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::delete('/reservations/{id}', [ReservationController::class, 'delete'])->name('reservation.delete');
});

require __DIR__.'/auth.php';
