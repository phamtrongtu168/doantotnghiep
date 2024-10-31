<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;

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
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-api', function () {
    return view('test-api');
});
Route::get('/rooms-store', function () {
    return view('rooms-store');
});