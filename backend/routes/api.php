<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\AdminPanel\BookingsController;
use App\Http\Controllers\AdminPanel\CarouselController;
use App\Http\Controllers\AdminPanel\ContactController;
use App\Http\Controllers\AdminPanel\DashboardController;
use App\Http\Controllers\AdminPanel\FacilityController;
use App\Http\Controllers\AdminPanel\FaviconController;
use App\Http\Controllers\AdminPanel\FeatureController;
use App\Http\Controllers\AdminPanel\InformationController;
use App\Http\Controllers\AdminPanel\LogoController;
use App\Http\Controllers\AdminPanel\RatingReviewController;
use App\Http\Controllers\AdminPanel\RoomController;
use App\Http\Controllers\AdminPanel\RoomFeatureFacilityController;
use App\Http\Controllers\AdminPanel\RoomImageController;
use App\Http\Controllers\AdminPanel\SettingController;
use App\Http\Controllers\AdminPanel\TeamController;

// Routes for admin dashboard
Route::prefix("/admin/dashboard")->middleware("auth:sanctum")->group(function () {
    Route::get("/summary", [DashboardController::class, "summary"]);
    Route::get("/booking-analytics/{period}", [DashboardController::class, "booking_analytics"]);
});

//--------------------------
// Admin profile routes
Route::prefix('/admin/profile')->group(function () {
    Route::post('/login', [AdminController::class, 'login']);
    Route::middleware("auth:sanctum")->group(function () {
        Route::get('/show/{id}', [AdminController::class, 'show']);
        Route::put('/update/password/{id}', [AdminController::class, 'update_password']);
        Route::post('/update/{id}', [AdminController::class, 'update_profile']);
        Route::delete('/logout', [AdminController::class, 'logout']);
    });
});
//---------------------

// Routes for booking record
Route::prefix("/admin")->middleware("auth:sanctum")->group(function () {
    Route::get("/all/bookings/{search?}", [BookingsController::class, "all_bookings"]);
    Route::get("/new/bookings/{search?}", [BookingsController::class, "new_bookings"]);
    Route::get("/refund/bookings/{search?}", [BookingsController::class, "refund_bookings"]);
    Route::put("/room/assign", [BookingsController::class, "room_assign"]);
    Route::put('/cancel-booking/{order_id}', [BookingsController::class, 'cancel']);
    Route::put('/refund-booking/{booking_order_id}', [BookingsController::class, 'refund']);
});
//--------------------------

// Room feature routes
Route::prefix("/admin/feature")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [FeatureController::class, 'index']);
    Route::post("/create", [FeatureController::class, 'create']);
    Route::get("/show/{id}", [FeatureController::class, 'show']);
    Route::put("/update/{id}", [FeatureController::class, 'update']);
    Route::delete("/delete/{id}", [FeatureController::class, 'delete']);
});
//--------------------

// Contact routes
Route::prefix("/admin/contact")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [ContactController::class, 'index']);
    Route::post("/create", [ContactController::class, 'create']);
    Route::get("/show/{id}", [ContactController::class, "show"]);
    Route::patch("/update/{id}", [ContactController::class, 'update']);
    Route::patch("/update/all/status", [ContactController::class, 'update_all']);
    Route::delete("/delete/{id}", [ContactController::class, 'delete']);
    Route::delete("/delete/all/record", [ContactController::class, 'delete_all']);
});
//--------------------

// Carousel routes for admin panel
Route::prefix("/admin/carousel")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [CarouselController::class, "index"]);
    Route::post("/create", [CarouselController::class, "create"]);
    Route::get("/show/{id}", [CarouselController::class, "show"]);
    Route::put("/update/{id}", [CarouselController::class, "update"]);
    Route::delete("/delete/{id}", [CarouselController::class, "delete"]);
});

// Favicon routes for admin panel
Route::prefix("/admin/favicon")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [FaviconController::class, "index"]);
    Route::put("/update", [FaviconController::class, "update"]);
});

// Logo routes for admin panel
Route::prefix("/admin/logo")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [LogoController::class, "index"]);
    Route::put("/update", [LogoController::class, "update"]);
});

// Team member routes for admin panel
Route::prefix("/admin/team")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [TeamController::class, "index"]);
    Route::post("/create", [TeamController::class, "create"]);
    Route::get("/show/{id}", [TeamController::class, "show"]);
    Route::put("/update/{id}", [TeamController::class, "update"]);
    Route::delete("/delete/{id}", [TeamController::class, "delete"]);
});

// Facility routes for admin panel
Route::prefix("/admin/facility")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [FacilityController::class, "index"]);
    Route::post("/create", [FacilityController::class, "create"]);
    Route::get("/show/{id}", [FacilityController::class, "show"]);
    Route::put("/update/{id}", [FacilityController::class, "update"]);
    Route::delete("/delete/{id}", [FacilityController::class, "delete"]);
});

// Settings routes for admin panel
Route::prefix("/admin/setting")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [SettingController::class, "index"]);
    Route::put("/shutdown", [SettingController::class, 'shutdown']);
    Route::put("/update", [SettingController::class, "update"]);
});

// Information routes for admin panel
Route::prefix("/admin/company/information")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [InformationController::class, "index"]);
    Route::put("/update", [InformationController::class, "update"]);
});

// Roome routes for admin panel
Route::prefix("/admin/room")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [RoomController::class, "index"]);
    Route::post("/create", [RoomController::class, "create"]);
    Route::get("/show/{id}", [RoomController::class, "show"]);
    Route::put("/update/{id}", [RoomController::class, "update"]);
    Route::put("/status/{id}", [RoomController::class, "status"]);
    Route::delete("/delete/{id}", [RoomController::class, "delete"]);
});

// Roome Image routes for admin panel
Route::prefix("/admin/room/image")->middleware("auth:sanctum")->group(function () {
    Route::get("/{room_id}", [RoomImageController::class, "get_image"]);
    Route::post("/create", [RoomImageController::class, "create"]);
    Route::put("/update/{id}", [RoomImageController::class, "update"]);
    Route::put("/thumbnail/{id}", [RoomImageController::class, "thumbnail"]);
    Route::delete("/delete/{id}", [RoomImageController::class, "delete"]);
});

// Roome feature & facility routes for admin panel
Route::prefix("/admin/room/feature-facility")->middleware("auth:sanctum")->group(function () {
    Route::get("/features-id/{room_id}", [RoomFeatureFacilityController::class, "get_room_features_id"]);
    Route::get("/facilities-id/{room_id}", [RoomFeatureFacilityController::class, "get_room_facilities_id"]);
    Route::post("/create", [RoomFeatureFacilityController::class, "create"]);
    Route::put("/update", [RoomFeatureFacilityController::class, "update"]);
});

// Roome ratings & reviews routes for admin panel
Route::prefix("/admin/room/ratings-reviews")->middleware("auth:sanctum")->group(function () {
    Route::get("/", [RatingReviewController::class, "index"]);
    Route::put("/status/{id}", [RatingReviewController::class, "status"]);
    Route::delete("/delete/{id}", [RatingReviewController::class, "delete"]);
});

// visitior panel related routes
use App\Http\Controllers\VisitiorPanel\FacilityController as VisitiorPanelFacilityController;
use App\Http\Controllers\VisitiorPanel\ContactController as VisitiorPanelContactController;
use App\Http\Controllers\VisitiorPanel\AddressController;
use App\Http\Controllers\VisitiorPanel\BookingInformationController;
use App\Http\Controllers\VisitiorPanel\CarouselController as VisitiorPanelCarouselController;
use App\Http\Controllers\VisitiorPanel\TeamMemberController;
use App\Http\Controllers\VisitiorPanel\SettingController as VisitiorPanelSettingController;
use App\Http\Controllers\VisitiorPanel\LogoController as VisitiorPanelLogoController;
use App\Http\Controllers\VisitiorPanel\RatingReviewController as VisitiorPanelRatingReviewController;
use App\Http\Controllers\VisitiorPanel\RoomController as VisitiorPanelRoomController;

// room facility routes for visitiors
Route::get('/facility', [VisitiorPanelFacilityController::class, 'index']);

// contact us routes for visitiors
Route::post('/contact', [VisitiorPanelContactController::class, 'create']);

// Company address routes for visitiors
Route::get('/address', [AddressController::class, 'index']);

// Carousel routes for visitiors
Route::get('/carousel', [VisitiorPanelCarouselController::class, 'index']);

// Team member routes
Route::get('/team-members', [TeamMemberController::class, 'index']);

// Settings routes for visitior panel
Route::get('/setting', [VisitiorPanelSettingController::class, 'index']);

// Logo routes for visitior panel
Route::get('/logo', [VisitiorPanelLogoController::class, 'index']);

// Rooms routes for visitior panel
Route::get('/all/room', [VisitiorPanelRoomController::class, 'all_room']);
Route::post('/filtered/room', [VisitiorPanelRoomController::class, 'filtered_room']);
Route::get('/max/person', [VisitiorPanelRoomController::class, 'max']);
Route::get('/room/{id}', [VisitiorPanelRoomController::class, 'room']);
Route::get('/confirm/room/{id}', [VisitiorPanelRoomController::class, 'confirm_room']);

// Room booking information routes
Route::post('/check/booking/information', [BookingInformationController::class, 'check_booking_information']);

// Rating & Review for room
Route::get('/rating-review/{room_id}', [VisitiorPanelRatingReviewController::class, 'index']);

// Routes for users
use App\Http\Controllers\UsersPanel\UserController;
use App\Http\Controllers\UsersPanel\MyBookingsController;

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);
Route::delete('/user/logout', [UserController::class, 'logout'])->middleware("auth:sanctum");
Route::prefix('/user/profile')->middleware('auth:sanctum')->group(function () {
    Route::put('/update/{id}', [UserController::class, 'profile_update']);
    Route::put('/update/photo/{id}', [UserController::class, 'update_photo']);
    Route::put('/update/password/{id}', [UserController::class, 'update_password']);
});

// booking records information routes for users
Route::get('/my-booking-records/{user_id}', [MyBookingsController::class, 'index'])->middleware("auth:sanctum");
Route::put('/cancel-my-booking', [MyBookingsController::class, 'cancel'])->middleware("auth:sanctum");
Route::post('/rating-review', [MyBookingsController::class, 'rating_review'])->middleware("auth:sanctum");
