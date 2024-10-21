<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Request\Auth\LoginRequest;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\articuloController;
use App\Http\Controllers\Api\categoriasController;
use App\Http\Controllers\Api\comentariosController;
use App\Models\Comentario;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//protected routec

//Route::middleware('jwt.verify')->group(function(){

//articulos=============================================================0

Route::get('/articulos', [articuloController::class, 'index']);

Route::get('/articulos/{id}', [articuloController::class, 'mostrar']);

Route::post('/articulos', [articuloController::class, 'store']);

Route::delete('/articulos/{id}', [articuloController::class, 'eliminar']);

Route::put('/articulos/{id}', [articuloController::class, 'actualizar']);

//categorias=============================================================================

Route::get('/categorias', [categoriasController::class, 'index']);

Route::get('/categorias/{id}', [categoriasController::class, 'mostrar']);

Route::post('/categorias', [categoriasController::class, 'store']);

Route::delete('/categorias/{id}', [categoriasController::class, 'eliminar']);

Route::put('/categorias/{id}', [categoriasController::class, 'actualizar']);

//comentarios===========================================================================

Route::get('/comentarios', [comentariosController::class, 'index']);

Route::get('/comentarios/{id}', [comentariosController::class, 'mostrar']);

Route::post('/comentarios', [comentariosController::class, 'store']);

Route::delete('/comentarios/{id}', [comentariosController::class, 'eliminar']);

Route::put('/comentarios/{id}', [comentariosController::class, 'actualizar']);

//autenticacion================================================================

Route::get('users', [UserController::class, 'index']);


Route::middleware(['jwt.verify'])->group(function () {
    //Route::get('users', [UserController::class, 'index']);
});



