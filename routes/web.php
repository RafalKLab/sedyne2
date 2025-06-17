<?php

use App\Http\Controllers\ProfileController;
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
});

Route::get('/spaces', [SpaceController::class, 'index'])->name('spaces');
Route::post('/spaces', [SpaceController::class, 'storeSpace']);

Route::get('/space/{id}/layout', [SpaceController::class, 'setupLayout'])->name('setup-layout');
Route::post('/space/{id}/layout', [SpaceController::class, 'saveLayout']);

Route::get('/space/{id}/preview', [SpaceController::class, 'previewSpace'])->name('space-preview');

Route::get('/demo', function () {
    return view('space-creator');
});

Route::get('/main', function () {
    return view('auth.register2');
});


require __DIR__.'/auth.php';
