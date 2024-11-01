<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\EmpresaController;

Route::get('motoristas', [MotoristaController::class, 'index']);
Route::post('motoristas', [MotoristaController::class, 'store']);
Route::put('motoristas/{id}', [MotoristaController::class, 'update']);
Route::delete('motoristas/{id}', [MotoristaController::class, 'destroy']);

Route::get('empresas', [EmpresaController::class, 'index']);
Route::post('/empresas', [EmpresaController::class, 'store']);
