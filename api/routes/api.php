<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotoristaController;

Route::get('motoristas', [MotoristaController::class, 'index']);
Route::post('motoristas', [MotoristaController::class, 'store']);
Route::put('motoristas/{id}', [MotoristaController::class, 'update']);
Route::delete('motoristas/{id}', [MotoristaController::class, 'destroy']);
