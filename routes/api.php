<?php

use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentifcation Routes (Register & Login)
Route::post('register', [RegisterUserController::class, 'store']);
Route::post('authenticate', [AuthSessionController::class, 'authenticate']);
Route::post('logout', [AuthSessionController::class, 'logout'])->middleware('auth:sanctum');




