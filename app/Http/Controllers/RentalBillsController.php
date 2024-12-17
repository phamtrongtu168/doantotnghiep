<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalBills;
class RentalBillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = RentalBills::with('rental')->get();
        return response()->json($bills);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'rental_id' => 'required|exists:rental_management,id',
                'month' => 'required|date_format:Y-m',
                'electricity_usage' => 'required|numeric',
                'water_usage' => 'required|numeric',
            ]);

            // Create a new rental bill record
            $rentalBill = RentalBills::create($validated);

            // Return a successful response with the created bill
            return response()->json([
                'message' => 'Rental bill created successfully',
                'bill' => $rentalBill
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            // Handle other general exceptions
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }x
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = RentalBills::with('rental')->findOrFail($id);
        return response()->json($bill);    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'electricity_usage' => 'required|numeric',
            'water_usage' => 'required|numeric',
        ]);

        $bill = RentalBills::findOrFail($id);
        $bill->update($validated);

        return response()->json(['message' => 'Rental bill updated successfully', 'bill' => $bill]);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = RentalBills::findOrFail($id);
        $bill->delete();
        return response()->json(['message' => 'Rental bill deleted successfully']);
    }
}
