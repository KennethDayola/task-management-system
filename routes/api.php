<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    Route::apiResource('projects', ProjectController::class)
    ->except(['create', 'edit'])
    ->names('api.projects');

    Route::apiResource('projects.tasks', TaskController::class)
        ->only(['store'])
        ->shallow()
        ->names('api.tasks');

    Route::apiResource('tasks', TaskController::class)
        ->only(['update', 'destroy'])
        ->names('api.tasks');
});