<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MovingRequestController;
use App\Http\Controllers\RepairRequestController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('{id}', [RoomController::class, 'show'])->name('rooms.show');
    Route::put('{id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});
Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);
    Route::get('/{id}', [BookingController::class, 'show']);
    Route::put('/{id}', [BookingController::class, 'update']);
    Route::delete('/{id}', [BookingController::class, 'destroy']);
    Route::get('/availability', [BookingController::class, 'checkAvailability']);
});
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::post('/', [ServiceController::class, 'store'])->name('services.store');
    Route::get('{id}', [ServiceController::class, 'show']);
    Route::put('{id}', [ServiceController::class, 'update']);
    Route::delete('{id}', [ServiceController::class, 'destroy']);
});

Route::prefix('moving-requests')->group(function () {
    Route::get('/', [MovingRequestController::class, 'index']);
    Route::post('/', [MovingRequestController::class, 'store']);
    Route::get('{id}', [MovingRequestController::class, 'show']);
    Route::put('{id}', [MovingRequestController::class, 'update']);
    Route::delete('{id}', [MovingRequestController::class, 'destroy']);
});

Route::prefix('repair-requests')->group(function () {
    Route::get('/', [RepairRequestController::class, 'index']);
    Route::post('/', [RepairRequestController::class, 'store']);
    Route::get('{id}', [RepairRequestController::class, 'show']);
    Route::put('{id}', [RepairRequestController::class, 'update']);
    Route::delete('{id}', [RepairRequestController::class, 'destroy']);
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