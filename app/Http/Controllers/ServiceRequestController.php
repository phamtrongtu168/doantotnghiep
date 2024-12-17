<?php
namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $serviceRequests = ServiceRequest::all();
        return response()->json($serviceRequests);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'room_id' => 'nullable|integer|exists:rooms,id',
            'service_id' => 'nullable|integer|exists:services,id',
            'request_type' => 'required|in:moving,repair,cleaning',
            'description' => 'nullable|string',
            'moving_from' => 'nullable|string',
            'moving_to' => 'nullable|string',
            'service_date' => 'nullable|date',
        ]);

        $serviceRequest = ServiceRequest::create($validatedData);
        return response()->json(['message' => 'Service request created successfully', 'data' => $serviceRequest], 201);
    }

    public function show($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        return response()->json($serviceRequest);
    }

    public function update(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'nullable|in:pending,approved,completed,rejected',
            'service_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $serviceRequest->update($validatedData);
        return response()->json(['message' => 'Service request updated successfully', 'data' => $serviceRequest]);
    }

    public function destroy($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->delete();
        return response()->json(['message' => 'Service request deleted successfully']);
    }
}
