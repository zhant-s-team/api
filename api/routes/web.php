<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VeiculosController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\RotaController;
use App\Http\Controllers\ViagemController;
use App\Http\Controllers\CargaController;

// Rotas para Veículos
Route::resource('veiculos', VeiculosController::class);

// Rotas para Motoristas
Route::resource('motoristas', MotoristaController::class);

// Rotas para cargas
Route::resource('cargas', CargaController::class);

// Rotas para Rotas
Route::resource('rotas', RotaController::class);

// Rotas para Viagens
Route::resource('viagens', ViagemController::class);

// Rota de início
Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação
Auth::routes();

// Rota para a página inicial após login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
