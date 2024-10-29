<?php
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index']);    // Lấy danh sách phòng
    Route::post('/', [RoomController::class, 'store']);   // Tạo phòng mới
    Route::get('{id}', [RoomController::class, 'show']);  // Lấy thông tin chi tiết của một phòng
    Route::put('{id}', [RoomController::class, 'update']); // Cập nhật phòng
    Route::delete('{id}', [RoomController::class, 'destroy']); // Xóa phòng
});
