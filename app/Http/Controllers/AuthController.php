<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /***
     * Action for registering user account
     *
     * @param \Illuminate\Http\Request $request
     */
    public function register(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create user account
        $user = User::create([
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Create access token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    /**
     * Login to the user account
     *
     * @param \Illuminate\Http\Request
     */
    public function login(Request $request)
    {
        // Login with email, password
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        // Fetch the user details
        $user = User::where('email', $request['email'])->firstOrFail();

        // Create a access token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Respond with the user personal access token
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    /**
     * Fetch account details
     *
     * @param \Illuminate\Http\Request
     */
    public function account(Request $request)
    {
        return $request->user();
    }
}
