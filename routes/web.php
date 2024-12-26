<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\RentalManagementController;
use App\Http\Controllers\RentalBillsController;
use App\Http\Controllers\FeedbackController;



Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);

});





Route::get('/rooms/search', [\App\Http\Controllers\RoomController::class, 'search']);

Route::get('rooms/available', [RoomController::class, 'getAvailableRooms']);


Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('{id}', [RoomController::class, 'show'])->name('rooms.show');
    Route::put('{id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});
// Route::middleware('auth:sanctum')->group(function (): void {
//     Route::get('/rooms', [RoomController::class, 'index']);
//     Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
//     Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
//     Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');
//     Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');
//     Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');
// });


Route::prefix('api')->group(function () {
    Route::get('rooms/{roomId}/feedbacks', [FeedbackController::class, 'index']);
    Route::post('feedbacks', [FeedbackController::class, 'store']);
    Route::delete('feedbacks/{id}', [FeedbackController::class, 'destroy']);
});
Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);
    Route::get('/{id}', [BookingController::class, 'show']);
    Route::put('/{id}', [BookingController::class, 'update']);
    Route::delete('/{id}', [BookingController::class, 'destroy']);
    Route::get('/availability', [BookingController::class, 'checkAvailability']);
});
Route::prefix('rental-management')->group(function () {
    Route::get('/', [RentalManagementController::class, 'index']);
    Route::get('/{id}', [RentalManagementController::class, 'show']);
    Route::post('/', [RentalManagementController::class, 'store']);
    Route::put('/{id}', [RentalManagementController::class, 'update']);
    Route::delete('/{id}', [RentalManagementController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/rooms', [RentalManagementController::class, 'getRoomsForUser']);

});
Route::prefix('rental-bills')->group(function () {
    Route::get('/', [RentalBillsController::class, 'index']);
    Route::post('/', [RentalBillsController::class,'store']);
    Route::get('/{id}', [RentalBillsController::class,'show']);
    Route::put('{id}', [RentalBillsController::class, 'update']);
    Route::delete('{id}', [RentalBillsController::class, 'destroy']);
});
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::post('/', [ServiceController::class, 'store'])->name('services.store');
    Route::get('{id}', [ServiceController::class, 'show']);
    Route::put('{id}', [ServiceController::class, 'update']);
    Route::delete('{id}', [ServiceController::class, 'destroy']);
});
Route::prefix('service-requests')->group(function () {
    Route::get('/', [ServiceRequestController::class, 'index']);
    Route::post('/', [ServiceRequestController::class, 'store']);
    Route::get('/{id}', [ServiceRequestController::class, 'show']);
    Route::put('/{id}', [ServiceRequestController::class, 'update']);
    Route::delete('/{id}', [ServiceRequestController::class, 'destroy']);
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-api', function () {
    return view('test-api');
});
Route::get('/rooms-store', function () {
    return view('rooms-store');
});
