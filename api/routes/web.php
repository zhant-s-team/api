<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\RotaController;
use App\Http\Controllers\VeiculosController;
use App\Http\Controllers\ViagemController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::get('entregas', [EntregaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('entregas');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


// Rota para a página inicial após login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Rotas para Motoristas
Route::resource('motoristas', MotoristaController::class);
// Rotas para cargas
Route::resource('cargas', CargaController::class);
// Rotas de autenticação
Auth::routes();

require __DIR__.'/auth.php';
