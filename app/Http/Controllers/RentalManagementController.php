<?php

namespace App\Http\Controllers;

use App\Models\RentalManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalManagementController extends Controller
{
    public function index()
    {
        $rentals = RentalManagement::with('room', 'tenant', 'landlord')->get();
        return response()->json($rentals);    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'landlord_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'required|numeric',
            'electricity_rate' => 'required|numeric',
            'water_rate' => 'required|numeric',
        ]);

        $rental = RentalManagement::create($validated);

        return response()->json(['message' => 'Rental contract created successfully', 'rental' => $rental], 201);
    }
    public function show($id) {
        $rental = RentalManagement::with('room', 'tenant', 'landlord')->findOrFail($id);
        return response()->json($rental);
    }
    public function update(Request $request, $id) {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'landlord_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'required|numeric',
            'electricity_rate' => 'required|numeric',
            'water_rate' => 'required|numeric',
        ]);

        $rental = RentalManagement::findOrFail($id);
        $rental->update($validated);

        return response()->json(['message' => 'Rental contract updated successfully', 'rental' => $rental]);
    }

    public function destroy($id)
    {
        $rental = RentalManagement::findOrFail($id);
        $rental->delete();

        return response()->json(['message' => 'Rental deleted successfully']);
    }
}