<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Rota de login
 */
Route::post('/login', [UserController::class, 'login']);

/**
 * Rotas para cadastrar,excluir, editar e ver usuários
 */
Route::apiResource('/users', UserController::class);

/**
 * Rotas para cadastrar,excluir, editar e ver os animais para adoção
 */
Route::apiResource('/animals', AnimalController::class);
