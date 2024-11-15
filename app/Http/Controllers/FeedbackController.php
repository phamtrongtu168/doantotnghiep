<?php

namespace App\Http\Controllers;

use App\Models\Feedbacks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index($roomId)
    {
        try {
            $feedbacks = Feedbacks::where('room_id', $roomId)->get();
            return response()->json($feedbacks, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch feedbacks: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'room_id' => 'required|integer|exists:rooms,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    $validated['user_id'] = $request->input('user_id', 2);

    $feedback = Feedbacks::create($validated);
    return response()->json([
        'message' => 'Feedback stored successfully',
        'data' => $feedback
    ]);
}


    public function destroy($id)
    {
        try {
            $feedback = Feedbacks::findOrFail($id);
            $feedback->delete();
            return response()->json(['message' => 'Feedback deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete feedback: ' . $e->getMessage()], 500);
        }
    }
}