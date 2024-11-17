<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Rotas públicas para empresas
Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
Route::get('/empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');

// Rotas públicas para entregas
Route::get('/entregas', [EntregaController::class, 'index'])->name('entregas.index');
Route::get('/entregas/{id}', [EntregaController::class, 'show'])->name('entregas.show');

// Rotas protegidas por autenticação
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Rotas das empresas (criar, editar, excluir)
    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');

    // Rotas das entregas (criar, editar, excluir)
    Route::post('/entregas', [EntregaController::class, 'store'])->name('entregas.store');
    Route::put('/entregas/{id}', [EntregaController::class, 'update'])->name('entregas.update');
    Route::delete('/entregas/{id}', [EntregaController::class, 'destroy'])->name('entregas.destroy');
    Route::post('/entregas/{entregaId}/aceitar', [EntregaController::class, 'aceitarEntrega'])->name('entregas.aceitar');

    //Rotas dos usuarios (criar, editar, excluir)
    Route::resource('users', UserController::class);
});
