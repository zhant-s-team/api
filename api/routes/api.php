<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//Route::get('/users', [AuthController::class, 'index']);

Route::get('/empresas', [EmpresaController::class, 'index']);
Route::post('/empresas', [EmpresaController::class, 'store']);
