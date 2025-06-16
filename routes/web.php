<?php

use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SpaceController::class, 'index'])->name('home');
Route::post('/', [SpaceController::class, 'storeSpace']);

Route::get('/space/{id}/layout', [SpaceController::class, 'setupLayout'])->name('setup-layout');
Route::post('/space/{id}/layout', [SpaceController::class, 'saveLayout']);

Route::get('/space/{id}/preview', [SpaceController::class, 'previewSpace'])->name('space-preview');

Route::get('/demo', function () {
    return view('space-creator');
});
