<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\RotaController;
use App\Http\Controllers\VeiculosController;
use App\Http\Livewire\UsuarioManager;
use App\Http\Controllers\EmpresaController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::get('entregas', [EntregaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('entregas');

    Route::get('/motoristas', function () {
        return view('livewire.motoristas');
    })->name('motoristas');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');

Route::get('/motoristas', [MotoristaController::class, 'index'])->name('motoristas');
// Rota para a página inicial após login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('motoristas', MotoristaController::class);
Route::get('/usuarios', function () {
    return view('usuarios');
})->name('usuarios.index');


// Rotas de autenticação
Auth::routes();

Route::get('/cidades', [CidadeController::class, 'index']);

require __DIR__.'/auth.php';
