<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Logiraj pristigle kredencijale (bez lozinke radi sigurnosti)
    \Log::info('Login attempt with email: ' . $request->input('email'));

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        // Logiraj uspješan login
        \Log::info('Login successful for user ID: ' . $user->id);
        return response()->json(['token' => $token]);
    }

    // Logiraj neuspješan login
    \Log::warning('Login failed for email: ' . $request->input('email'));
    return response()->json(['message' => 'Invalid credentials'], 401);
}

}
