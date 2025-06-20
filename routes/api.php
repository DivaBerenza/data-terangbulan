<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenstruationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/menstruations', [MenstruationController::class, 'store']);
    Route::get('/menstruations', [MenstruationController::class, 'index']);
    Route::put('/user', [AuthController::class, 'updateProfile']);
});