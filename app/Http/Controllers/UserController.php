<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Đăng ký: Done
    public function register(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'in:user,landlord,admin'

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'user'
        ]);

        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
    }
}

    // Đăng nhập: Done
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email or Password is valid'], 401);
        }

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out successfully',
        ]);
    }

    // Lấy thông tin người dùng đã xác thực
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request)
    {
        $user = $request->user();

        // Validate các trường cần thiết
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:6|confirmed',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        // Cập nhật thông tin người dùng
        $user->update($validatedData);

        return response()->json([
            'message' => 'User information updated successfully',
            'user' => $user,
        ]);
    }

    // Xóa người dùng
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Xóa người dùng
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

}