<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\articuloController;
use App\Http\Controllers\Api\categoriasController;

Route::get('/articulos', [articuloController::class, 'index']);

Route::post('/articulos', [articuloController::class, 'store']);


Route::get('/categorias', [categoriasController::class, 'index']);

Route::post('/categorias', [categoriasController::class, 'store']);
