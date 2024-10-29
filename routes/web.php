<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index']);    // Lấy danh sách phòng
    Route::post('/', [RoomController::class, 'store'])->name('rooms.store');   // Tạo phòng mới
    Route::get('{id}', [RoomController::class, 'show']);  // Lấy thông tin chi tiết của một phòng
    Route::put('{id}', [RoomController::class, 'update']); // Cập nhật phòng
    Route::delete('{id}', [RoomController::class, 'destroy']); // Xóa phòng
});



Route::get('/', function () {
    return view('welcome');
});
// routes/web.php

Route::get('/test-api', function () {
    return view('test-api');
});
