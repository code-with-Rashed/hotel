<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\AdminPanel\CarouselController;
use App\Http\Controllers\AdminPanel\ContactController;
use App\Http\Controllers\AdminPanel\FacilityController;
use App\Http\Controllers\AdminPanel\FaviconController;
use App\Http\Controllers\AdminPanel\FeatureController;
use App\Http\Controllers\AdminPanel\InformationController;
use App\Http\Controllers\AdminPanel\LogoController;
use App\Http\Controllers\AdminPanel\SettingController;
use App\Http\Controllers\AdminPanel\TeamController;

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

// Room feature routes
Route::prefix("/admin/feature")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [FeatureController::class, 'index']);
    Route::post("/create", [FeatureController::class, 'create']);
    Route::put("/update/{id}", [FeatureController::class, 'update']);
    Route::delete("/delete/{id}", [FeatureController::class, 'delete']);
});
//--------------------

// Contact routes
Route::prefix("/admin/contact")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [ContactController::class, 'index']);
    Route::post("/create", [ContactController::class, 'create']);
    Route::patch("/update/{id}", [ContactController::class, 'update']);
    Route::delete("/delete/{id}", [ContactController::class, 'delete']);
});
//--------------------

// Carousel routes for admin panel
Route::prefix("/admin/carousel")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [CarouselController::class, "index"]);
    Route::post("/create", [CarouselController::class, "create"]);
    Route::post("/update/{id}", [CarouselController::class, "update"]);
    Route::delete("/delete/{id}", [CarouselController::class, "delete"]);
});

// Favicon routes for admin panel
Route::prefix("/admin/favicon")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [FaviconController::class, "index"]);
    Route::post("/update", [FaviconController::class, "update"]);
});

// Logo routes for admin panel
Route::prefix("/admin/logo")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [LogoController::class, "index"]);
    Route::post("/update", [LogoController::class, "update"]);
});

// Team member routes for admin panel
Route::prefix("/admin/team")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [TeamController::class, "index"]);
    Route::post("/create", [TeamController::class, "create"]);
    Route::get("/show/{id}", [TeamController::class, "show"]);
    Route::post("/update/{id}", [TeamController::class, "update"]);
    Route::delete("/delete/{id}", [TeamController::class, "delete"]);
});

// Facility routes for admin panel
Route::prefix("/admin/facility")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [FacilityController::class, "index"]);
    Route::post("/create", [FacilityController::class, "create"]);
    Route::get("/show/{id}", [FacilityController::class, "show"]);
    Route::post("/update/{id}", [FacilityController::class, "update"]);
    Route::delete("/delete/{id}", [FacilityController::class, "delete"]);
});

// Settings routes for admin panel
Route::prefix("/admin/setting")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [SettingController::class, "index"]);
    Route::patch("/shutdown", [SettingController::class, 'shutdown']);
    Route::patch("/update", [SettingController::class, "update"]);
});

// Information routes for admin panel
Route::prefix("/admin/company/information")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [InformationController::class, "index"]);
    Route::put("/update", [InformationController::class, "update"]);
});
