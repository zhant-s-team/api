<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntregaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;

//Rota de criar novo usuario
Route::post('/register', [AuthController::class, 'register']);
//Rota de logar
Route::post('/login', [AuthController::class, 'login']);
//Route::get('/users', [AuthController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    //Rotas das empresas
    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('/empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');
    Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');


    //Rotas das entregas
    Route::get('/entregas', [EntregaController::class, 'index'])->name('entregas.index');
    Route::get('/entregas/{id}', [EntregaController::class, 'show'])->name('entregas.show');
    Route::post('/entregas', [EntregaController::class, 'store'])->name('entregas.store');
    Route::put('/entregas/{id}', [EntregaController::class, 'update'])->name('entregas.update');
    Route::delete('/entregas/{id}', [EntregaController::class, 'destroy'])->name('entregas.destroy');
    //Route::post('/entregas/{entregaId}/aceitar', [EntregaController::class, 'aceitarEntrega'])->name('entregas.aceitar');
});
