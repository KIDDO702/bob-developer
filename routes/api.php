<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentifcation Routes (Register & Login)
Route::post('register', [RegisterUserController::class, 'store']);
Route::post('authenticate', [AuthSessionController::class, 'authenticate']);
Route::post('logout', [AuthSessionController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
});



