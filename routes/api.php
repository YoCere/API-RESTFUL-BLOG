<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Request\Auth\LoginRequest;
use App\Http\Controllers\UserController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//protected routec

//Route::middleware('jwt.verify')->group(function(){
Route::get('users', [UserController::class, 'index']);

Route::middleware(['jwt.verify'])->group(function () {
    //Route::get('users', [UserController::class, 'index']);
});


use App\Http\Controllers\Api\articuloController;
use App\Http\Controllers\Api\categoriasController;

Route::get('/articulos', [articuloController::class, 'index']);

Route::post('/articulos', [articuloController::class, 'store']);


Route::get('/categorias', [categoriasController::class, 'index']);

Route::post('/categorias', [categoriasController::class, 'store']);
