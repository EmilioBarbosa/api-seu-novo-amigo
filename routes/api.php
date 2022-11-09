<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StateController;
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

Route::get('/states', [StateController::class, 'index']);

Route::get('/cities', [CityController::class, 'index']);

Route::get('/image/animal/{image}', [ImageController::class, 'getAnimalImage']);
