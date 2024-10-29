<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RoomController extends Controller
{
    // Lấy danh sách phòng
    public function index()
    {
        $rooms = Room::with('images')->get();
        return response()->json($rooms);
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'area' => 'required|numeric',
        'max_occupants' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // 'province_id' => 'required|integer|exists:provinces,id', // Kiểm tra province_id
        // 'district_id' => 'required|integer|exists:districts,id', // Kiểm tra district_id
        'air_conditioners' => 'required|integer|min:0', // Số điều hòa
        'kitchens' => 'required|integer|min:0', // Số bếp
        'refrigerators' => 'required|integer|min:0', // Số tủ lạnh
        'washing_machines' => 'required|integer|min:0', // Số máy giặt
        'toilets' => 'required|integer|min:0', // Số toilet
        'bathrooms' => 'required|integer|min:0', // Số phòng tắm
        'bedrooms' => 'required|integer|min:0', // Số phòng ngủ
    ]);

    $imageUrl = null;

    // Tải lên hình ảnh lên Cloudinary
    if ($request->hasFile('image')) {
        $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'rooms',
        ]);
        $imageUrl = $uploadResult->getSecureUrl();
    }

    // Tạo mới phòng
    $room = Room::create(array_merge($request->all(), ['image_url' => $imageUrl]));

    // Nếu có hình ảnh, lưu vào bảng RoomImages
    if ($imageUrl) {
        RoomImage::create([
            'room_id' => $room->id,
            'image_url' => $imageUrl,
        ]);
    }

    return response()->json($room, 201);
}


    // // Tạo mới phòng
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'price' => 'required|numeric',
    //         'area' => 'required|numeric',
    //         'max_occupants' => 'required|integer',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

    //     ]);

    //     $imageUrl = null;

    //     // Tải lên hình ảnh lên Cloudinary
    //     if ($request->hasFile('image')) {
    //         $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
    //             'folder' => 'rooms',
    //         ]);
    //         $imageUrl = $uploadResult->getSecurePath();
    //     }

    //     $room = Room::create(array_merge($request->all(), ['image_url' => $imageUrl]));

    //     return response()->json($room, 201);
    // }

    // Lấy chi tiết phòng
    public function show($id)
    {
        $room = Room::with('images')->findOrFail($id);
        return response()->json($room);
    }

    // Cập nhật phòng
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric',
            'area' => 'numeric',
            'max_occupants' => 'integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tải lên hình ảnh mới nếu có
        if ($request->hasFile('image')) {
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'rooms',
            ]);
            $room->image_url = $uploadResult->getSecurePath();
        }

        // Cập nhật thông tin phòng
        $room->update($request->except('image'));

        return response()->json($room);
    }

    // Xóa phòng
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(null, 204);
    }
}
