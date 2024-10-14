<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\articuloController;

Route::get('/articulos', [articuloController::class, 'index']);
