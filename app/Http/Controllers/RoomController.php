<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
class RoomController extends Controller
{
    // Search phòng:
    public function search(Request $request)
{
    $provinceId = $request->input('province_id');
    $districtId = $request->input('district_id');
    $priceFrom = $request->input('price_from', 500000);
    $maxOccupants = $request->input('max_occupants', 1);

    $query = Room::query();

    if ($provinceId != 0) {
        $query->where('province_id', $provinceId);
    }

    if ($districtId != 0) {
        $query->where('district_id', $districtId);
    }

    if (!is_null($priceFrom)) {
        $query->where('price', '>=', $priceFrom);
    }

    if ($maxOccupants != 0) {
        $query->where('max_occupants', '>=', $maxOccupants);
    }

    $rooms = $query->with('images')->paginate(9);

    return response()->json([
        'success' => true,
        'data' => $rooms
    ], 200);
}

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
    $landlordId = Auth::id();
    if (is_null($landlordId)) {
        return response()->json(['error' => 'Unauthorized: landlord_id is missing'], 401);
    }

    $validatedData = $request->validate([
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
        'bedrooms' => 'required|integer|min:0'

    ]);
    $validatedData['landlord_id'] = $landlordId;

    try {
        $room = Room::create($validatedData);

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
    return response()->json(['message' => 'Room created successfully', 'room' => $room], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to create room: ' . $e->getMessage()], 500);
    }

}

//Update phòng: unfinished
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        $room->update($request->all());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->getError() === 0) {
                    try {
                        $uploadResult = Cloudinary::upload($image->getRealPath(), [
                            'folder' => 'rooms',
                        ]);
                        $imageUrl = $uploadResult->getSecurePath();

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

        return response()->json('Successfully deleted the room.');
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete room: ' . $e->getMessage()], 500);
    }
}





}