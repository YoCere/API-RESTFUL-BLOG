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
//Route::get('users', [UserController::class, 'index']);

Route::middleware(['jwt.verify'])->group(function () {
    Route::get('users', [UserController::class, 'index']);
});


