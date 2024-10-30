<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
class RoomController extends Controller
{
    // Lấy danh sách phòng: Done
    public function index()
    {
        $rooms = Room::with('images')->get();
        return response()->json($rooms);
    }
    // Lấy chi tiết phòng: Done
    public function show($id)
    {
        $room = Room::with('images')->findOrFail($id);
        return response()->json($room);
    }
    public function create()
{
    return view('rooms.create');
}
public function store(Request $request)
{
    // Kiểm tra dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'area' => 'required|numeric',
        'max_occupants' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'air_conditioners' => 'required|integer|min:0',
        'kitchens' => 'required|integer|min:0',
        'refrigerators' => 'required|integer|min:0',
        'washing_machines' => 'required|integer|min:0',
        'toilets' => 'required|integer|min:0',
        'bathrooms' => 'required|integer|min:0',
        'bedrooms' => 'required|integer|min:0',
    ]);
    // Tạo mới phòng mà không cần hình ảnh
    $room = Room::create($request->all());
    if ($request->hasFile('image')) {
        if ($request->file('image')->getError() !== 0) {
            return response()->json(['error' => 'File upload error: ' . $request->file('image')->getError()], 400);
        }

        try {
            // Tải lên hình ảnh lên Cloudinary
            $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'rooms',
                'resource_type' => 'image',
            ]);

            $imageUrl = $uploadResult->getSecurePath();
            // Lưu vào bảng room_images
            RoomImage::create([
                'room_id' => $room->id,
                'image_url' => $imageUrl,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload image to Cloudinary: ' . $e->getMessage()], 500);
        }
    }
    return response()->json($room, 201);
}

// public function store(Request $request)
// {
//     // Kiểm tra dữ liệu đầu vào
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'price' => 'required|numeric',
//         'area' => 'required|numeric',
//         'max_occupants' => 'required|integer',
//         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         'air_conditioners' => 'required|integer|min:0',
//         'kitchens' => 'required|integer|min:0',
//         'refrigerators' => 'required|integer|min:0',
//         'washing_machines' => 'required|integer|min:0',
//         'toilets' => 'required|integer|min:0',
//         'bathrooms' => 'required|integer|min:0',
//         'bedrooms' => 'required|integer|min:0',
//     ]);

//     $imageUrl = null;

//     // Tải lên hình ảnh lên Cloudinary
//     if ($request->hasFile('image')) {
//         try {
//             $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
//                 'folder' => 'rooms',
//             ]);
//             $imageUrl = $uploadResult->getSecurePath();
//         } catch (\Exception $e) {
//             return response()->json(['error' => 'Failed to upload image to Cloudinary: ' . $e->getMessage()], 500);
//         }
//     }

//     // Tạo mới phòng
//     $room = Room::create(array_merge($request->all(), ['image_url' => $imageUrl]));

//     // Nếu có hình ảnh, lưu vào bảng RoomImages
//     if ($imageUrl) {
//         RoomImage::create([
//             'room_id' => $room->id,
//             'image_url' => $imageUrl,
//         ]);
//     }

//     return response()->json($room, 201);
// }


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
