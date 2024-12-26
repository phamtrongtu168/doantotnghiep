<?php

namespace App\Http\Controllers;

use App\Models\RentalManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalManagementController extends Controller
{
    // Lấy danh sách tất cả các hợp đồng thuê
    public function index()
    {
        $rentals = RentalManagement::with(['room', 'tenant','rentalBills'])->get();
        return response()->json($rentals);
    }

    // Tạo một hợp đồng thuê mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:active,pending,completed,cancelled',
        ]);

        $rental = RentalManagement::create($validated);

        return response()->json([
            'message' => 'Rental contract created successfully.',
            'data' => $rental
        ], 201);
    }

    // Lấy thông tin chi tiết của một hợp đồng thuê
    public function show($id)
    {
        $rental = RentalManagement::with(['room', 'tenant','rentalBills'])->find($id);

        if (!$rental) {
            return response()->json(['message' => 'Rental contract not found.'], 404);
        }

        return response()->json($rental);
    }

    // Cập nhật thông tin hợp đồng thuê
    public function update(Request $request, $id)
    {
        $rental = RentalManagement::find($id);

        if (!$rental) {
            return response()->json(['message' => 'Rental contract not found.'], 404);
        }

        $validated = $request->validate([
            'room_id' => 'sometimes|exists:rooms,id',
            'tenant_id' => 'sometimes|exists:users,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'sometimes|in:active,pending,completed,cancelled',
        ]);

        $rental->update($validated);

        return response()->json([
            'message' => 'Rental contract updated successfully.',
            'data' => $rental
        ]);
    }

    // Xóa một hợp đồng thuê
    public function destroy($id)
    {
        $rental = RentalManagement::find($id);

        if (!$rental) {
            return response()->json(['message' => 'Rental contract not found.'], 404);
        }

        $rental->delete();

        return response()->json(['message' => 'Rental contract deleted successfully.']);
    }
    //Dành cho user
    public function getRoomsForUser()
    {
        $userId = Auth::id();
        $rentals = RentalManagement::with(['room', 'rentalBills'])
                    ->where('tenant_id', $userId)
                    ->get();

        if ($rentals->isEmpty()) {
            return response()->json(['message' => 'No rental contracts found for this user.'], 404);
        }

        $roomsWithBills = $rentals->map(function ($rental) {
            return [
                'room' => $rental->room,
                'rentalBills' => $rental->rentalBills
            ];
        });

        return response()->json($roomsWithBills);
    }
}