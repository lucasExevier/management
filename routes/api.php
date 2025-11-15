<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::put('/user/profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::post('/user/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Projects
    Route::apiResource('projects', ProjectController::class);

    // Tasks
    Route::apiResource('tasks', TaskController::class);

    // Boards
Route::apiResource('boards', BoardController::class);
Route::patch('boards/{id}/position', [BoardController::class, 'updatePosition']);
});
