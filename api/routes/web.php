<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\Controller;


Route::view('/', 'welcome');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
//Rotas de dashboard
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
//Rotas de empresas


// Listagem de entregas

Route::get('entregas', [EntregaController::class, 'index'])->middleware(['auth', 'verified'])->name('entregas');
Route::get('/entregas', [EntregaController::class, 'index'])->middleware(['auth', 'verified'])->name('entregas');

Route::get('/entregas/create', [EntregaController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('entregas.create');
Route::post('/entregas', [EntregaController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('entregas.store');
Route::get('/entregas/{id}/edit', [EntregaController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('entregas.edit');
Route::put('/entregas/{id}', [EntregaController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('entregas.update');
Route::delete('/entregas/{id}', [EntregaController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('entregas.destroy');
    Route::post('/entrega', [EntregaController::class, 'store'])->name('entrega.store');

//    Route::get('empresas', [EntregaController::class, 'index'])
//    ->middleware(['auth', 'verified'])
//    ->name('empresas');
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
Route::resource('empresas', EmpresaController::class);
Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas');
// Rotas de autenticação
Auth::routes();
Route::get('/cidades', [CidadeController::class, 'index']);
require __DIR__.'/auth.php';
