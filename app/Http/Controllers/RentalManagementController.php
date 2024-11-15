<?php

namespace App\Http\Controllers;

use App\Models\RentalManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalManagementController extends Controller
{
    public function index()
    {
        return RentalManagement::with(['room', 'tenant', 'landlord'])->get();
    }
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'tenant_id' => 'required|exists:users,id',
        'landlord_id' => 'required|exists:users,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'rent_amount' => 'required|numeric|min:0',
        'status' => 'required|string'
    ]);

    try {
        $rental = RentalManagement::create(attributes: $validatedData);

        return response()->json([
            'message' => 'Rental created successfully',
            'data' => $rental
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to create rental',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        $rental = RentalManagement::findOrFail($id);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric',
            'status' => 'required|in:active,pending,completed,cancelled',
        ]);

        $rental->update($validated);

        return response()->json(['message' => 'Rental updated successfully']);
    }

    public function destroy($id)
    {
        $rental = RentalManagement::findOrFail($id);
        $rental->delete();

        return response()->json(['message' => 'Rental deleted successfully']);
    }
}
