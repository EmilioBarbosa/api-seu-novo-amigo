<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/login', [UserController::class, 'login']);

/**
 * Rotas para cadastrar,excluir, editar e ver usuários
 */
Route::apiResource('/users', UserController::class);
