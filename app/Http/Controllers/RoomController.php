<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'area' => 'required|numeric',
        'max_occupants' => 'required|integer',
        'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'air_conditioners' => 'required|integer|min:0',
        'kitchens' => 'required|integer|min:0',
        'refrigerators' => 'required|integer|min:0',
        'washing_machines' => 'required|integer|min:0',
        'toilets' => 'required|integer|min:0',
        'bathrooms' => 'required|integer|min:0',
        'bedrooms' => 'required|integer|min:0',
    ]);
    $room = Room::create($request->all());
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            if (!$image->isValid()) {
                return response()->json(['error' => 'File upload error: ' . $image->getErrorMessage()], 400);
            }
            try {
                $uploadResult = Cloudinary::upload($image->getRealPath(), [
                    'folder' => 'rooms',
                ]);

                RoomImage::create([
                    'room_id' => $room->id,
                    'image_url' => $uploadResult->getSecurePath(),
                ]);

            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to upload image to Cloudinary: ' . $e->getMessage()], 500);
            }
        }
    }
    return response()->json($room, 201);
}
public function update(Request $request, $id)
{
    try {
        $room = Room::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric',
            'area' => 'numeric',
            'max_occupants' => 'integer',
            'air_conditioners' => 'integer|min:0',
            'kitchens' => 'integer|min:0',
            'refrigerators' => 'integer|min:0',
            'washing_machines' => 'integer|min:0',
            'toilets' => 'integer|min:0',
            'bathrooms' => 'integer|min:0',
            'bedrooms' => 'integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Xác thực cho nhiều hình ảnh
        ]);

        // Cập nhật thông tin phòng
        $room->update($request->all());

        // Xử lý hình ảnh
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->getError() === 0) {
                    try {
                        $uploadResult = Cloudinary::upload($image->getRealPath(), [
                            'folder' => 'rooms',
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
            }
        }

        return response()->json($room);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}


// public function update(Request $request, $id)
// {
//     $room = Room::findOrFail($id);

//     $request->validate([
//         'name' => 'string|max:255',
//         'description' => 'nullable|string',
//         'price' => 'numeric',
//         'area' => 'numeric',
//         'max_occupants' => 'integer',
//         'air_conditioners' => 'integer|min:0',
//         'kitchens' => 'integer|min:0',
//         'refrigerators' => 'integer|min:0',
//         'washing_machines' => 'integer|min:0',
//         'toilets' => 'integer|min:0',
//         'bathrooms' => 'integer|min:0',
//         'bedrooms' => 'integer|min:0',
//         'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     $room->update($request->except('images'));

//     if ($request->hasFile('images')) {
//         foreach ($room->images as $image) {
//             Cloudinary::destroy($image->public_id);
//             $image->delete();
//         }

//         foreach ($request->file('images') as $newImage) {
//             $uploadResult = Cloudinary::upload($newImage->getRealPath(), [
//                 'folder' => 'rooms',
//             ]);

//             RoomImage::create([
//                 'room_id' => $room->id,
//                 'image_url' => $uploadResult->getSecurePath(),
//                 'public_id' => $uploadResult->getPublicId(),
//             ]);
//         }
//     }

//     return response()->json($room);
// }
// Xóa phòng: Done
public function destroy($id)
{
    try {
        $room = Room::with('images')->findOrFail($id);
        foreach ($room->images as $image) {
            Cloudinary::destroy($image->image_url);
            $image->delete();
        }

        $room->delete();

        return response()->json('Phòng đã xóa thành công.');
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete room: ' . $e->getMessage()], 500);
    }
}





}