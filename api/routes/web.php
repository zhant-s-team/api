<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\Controller;
use App\Http\Livewire\Empresas\Edit;

Route::view('/', 'welcome');
// Rota para a página inicial após login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::get('entregas', [EntregaController::class, 'index'])->middleware(['auth', 'verified'])->name('entregas');

//    Route::get('empresas', [EntregaController::class, 'index'])
//    ->middleware(['auth', 'verified'])
//    ->name('empresas');

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
Route::get('/empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');

Route::resource('empresas', EmpresaController::class);
Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas');

Route::get('/usuarios', function () {
    return view('usuarios');
})->name('usuarios.index');


// Rotas de autenticação
Auth::routes();

Route::get('/cidades', [CidadeController::class, 'index']);

require __DIR__.'/auth.php';
