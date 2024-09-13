<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ViagemController;
use App\Http\Controllers\RotaController;
use App\Http\Controllers\PassagemController;
use App\Http\Controllers\MotoristaController;

Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('veiculos', VeiculoController::class);
Route::apiResource('viagens', ViagemController::class);
Route::apiResource('rotas', RotaController::class);
Route::apiResource('passagens', PassagemController::class);
Route::apiResource('motoristas', MotoristaController::class);


Route::get('/', function () {
    return view('welcome');
});
