<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminPanel\AdminController;

// Admin profile routes
Route::prefix('/admin/profile')->group(function () {
    Route::post('/login', [AdminController::class, 'login']);
    Route::middleware("auth:sanctum")->group(function () {
        Route::put('/update/password/{id}', [AdminController::class, 'update_password']);
        Route::post('/update/profile/{id}', [AdminController::class, 'update_profile']);
        Route::delete('/logout', [AdminController::class, 'logout']);
    });
});
//---------------------
