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

    Route::controller(CategoryController::class)->group( function () {
        Route::get('/categories', 'index');
        Route::post('/category/create', 'store');
        Route::get('/category/{id}', 'show');
        Route::put('/category/u/{id}', 'update');
        Route::delete('category/d/{id}', 'destroy');
    });
});



