<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalBills;
class RentalBillsController extends Controller
{public function index()
    {
        $query = RentalBills::query();
        // Nếu muốn sử dụng phân trang (9 bản ghi mỗi trang)
        $rentalBills = $query->paginate(9);

        return response()->json([
            'message' => 'Rental bills retrieved successfully.',
            'data' => $rentalBills
        ]);
    }

    // Tạo một hóa đơn mới
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'rental_id' => 'required|exists:rental_managements,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'electricity_usage' => 'nullable|numeric|min:0',
                'water_usage' => 'nullable|numeric|min:0',
                'status' => 'nullable|in:pending,paid,overdue',
            ]);

            $rentalBill = RentalBills::create($validated);

            return response()->json([
                'message' => 'Rental bill created successfully.',
                'data' => $rentalBill
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the rental bill.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Lấy thông tin chi tiết của một hóa đơn
    public function show($id)
    {
        $rentalBill = RentalBills::find($id);

        if (!$rentalBill) {
            return response()->json([
                'message' => 'Rental bill not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Rental bill retrieved successfully.',
            'data' => $rentalBill
        ]);
    }

    // Cập nhật thông tin hóa đơn
    public function update(Request $request, $id)
    {
        $rentalBill = RentalBills::find($id);

        if (!$rentalBill) {
            return response()->json(['message' => 'Rental bill not found.'], 404);
        }

        $validated = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'electricity_usage' => 'sometimes|numeric|min:0',
            'water_usage' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:pending,paid,overdue',
        ]);

        $rentalBill->update($validated);

        return response()->json([
            'message' => 'Rental bill updated successfully.',
            'data' => $rentalBill
        ]);
    }

    // Xóa một hóa đơn
    public function destroy($id)
    {
        $rentalBill = RentalBills::find($id);

        if (!$rentalBill) {
            return response()->json(['message' => 'Rental bill not found.'], 404);
        }

        $rentalBill->delete();

        return response()->json(['message' => 'Rental bill deleted successfully.']);
    }
}