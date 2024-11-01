<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::all();
    }
    //Store services: Done
    public function store(Request $request)
{
    $request->validate([
        'service_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'service_type' => 'required|in:moving,repair',
    ]);

    $service = Service::create($request->all());

    return response()->json($service, 201);
}
    //Show services: Done
    public function show($id)
    {
        return Service::findOrFail($id);
    }
    //Update services: Done
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return $service;
    }
    //Destroy services: Done
    public function destroy($id)
    {
        Service::destroy($id);
        return response()->json('Delete Successful');
    }
}
