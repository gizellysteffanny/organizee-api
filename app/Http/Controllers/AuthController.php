<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function signUp(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'data'=>'User successfully created'
        ], 201);
    }
    
    public function signIn(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($data))
            return response()->json([
                'data'=>'Invalid email or password'
            ], 401);
        
        $user = $request->user();
        $token = $user->createToken('Access Token')->accessToken;

        return response()->json([
            'name' => $user->name,
            'token' => $token
        ], 200);
    }

    public function signOut(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'data' => 'successfully logged out'
        ], 200);
    }
}
