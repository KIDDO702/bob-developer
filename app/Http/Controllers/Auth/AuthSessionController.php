<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthSessionController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $remember = $request->filled('remember');

        $user = User::where('email', $credentials['email'])->first();

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials, Please Try Again'], 401);
        }

        // Check if the authenticated user has the "admin" role
        if (!auth()->user()->hasRole('admin')) {
            Auth::logout(); // Logout user if not admin
            return response()->json(['error' => 'Only admins are allowed to access the dashboard'], 403);
        }

        // Create token with conditional expiration
        $tokenResult = $user->createToken('user-token');


        return response()->json([
            'success' => 'Logged In successfully',
            'user' => $user,
            'token' => $tokenResult->plainTextToken,
        ], 200);
    }


    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        $token->delete();

        return response()->json([
            'success' => 'Logged out successfully from this device'
        ], 200);
    }
}
