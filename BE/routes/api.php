<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class);

Route::prefix('v1')->group(function (): void {
    Route::apiResource('tasks', TaskController::class);
});
