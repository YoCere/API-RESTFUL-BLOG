<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Request\Auth\LoginRequest;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\articuloController;
use App\Http\Controllers\Api\categoriasController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//protected routec

//Route::middleware('jwt.verify')->group(function(){




//Route::get('users', [UserController::class, 'index']);


Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);

    Route::get('/articulos', [articuloController::class, 'index']);

Route::get('/articulos/{id}', [articuloController::class, 'mostrar']);

Route::post('/articulos', [articuloController::class, 'store']);

Route::delete('/articulos/{id}', [articuloController::class, 'eliminar']);

Route::put('/articulos/{id}', [articuloController::class, 'actualizar']);


Route::get('/categorias', [categoriasController::class, 'index']);

Route::get('/categorias/{id}', [categoriasController::class, 'mostrar']);

Route::post('/categorias', [categoriasController::class, 'store']);

Route::delete('/categorias/{id}', [categoriasController::class, 'eliminar']);

Route::put('/categorias/{id}', [categoriasController::class, 'actualizar']);

});



