<?php

namespace App\Http\Controllers;

use App\Models\MovingRequest;
use Illuminate\Http\Request;

class MovingRequestController extends Controller
{
    public function index()
{
    try {
        $movingRequests = MovingRequest::all();
        return response()->json($movingRequests);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch moving requests: ' . $e->getMessage()], 500);
    }
}

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'moving_from' => 'required|string',
            'moving_to' => 'required|string',
            'moving_date' => 'required|date',
            'service_id' => 'required|exists:services,id',
        ]);

        return MovingRequest::create($request->all());
    }

    public function show($id)
    {
        return MovingRequest::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $movingRequest = MovingRequest::findOrFail($id);
        $movingRequest->update($request->all());
        return $movingRequest;
    }

    public function destroy($id)
    {
        MovingRequest::destroy($id);
        return response()->json('Delete Successful');
    }
}
// Moving-Request Done All.