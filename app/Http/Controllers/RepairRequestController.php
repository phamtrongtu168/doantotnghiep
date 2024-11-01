<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\Request;

class RepairRequestController extends Controller
{
    public function index()
    {
        return RepairRequest::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'description' => 'required|string',
            'service_id' => 'required|exists:services,id',
        ]);

        return RepairRequest::create($request->all());
    }

    public function show($id)
    {
        return RepairRequest::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $repairRequest = RepairRequest::findOrFail($id);
        $repairRequest->update($request->all());
        return $repairRequest;
    }

    public function destroy($id)
    {
        RepairRequest::destroy($id);
        return response()->json('Delete Successful');
    }
}