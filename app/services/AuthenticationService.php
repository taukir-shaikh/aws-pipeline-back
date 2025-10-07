<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function authenticate($email, $password) {
        $user = DB::table('users')->where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'token' => $user->createToken('auth_token')->plainTextToken
            ],200);
        } else {
            return response()->json(['error' => 'Invalid credentials'],401);
        }
    }

    public function registerUser($data) {
        $existingUser = DB::table('users')->where('email', $data['email'])->first();
        if ($existingUser) {
            return response()->json(['error' => 'User already exists'], 409);
        }

        DB::table('users')->insert([
            'name' => $data['name'] ?? '',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $data['email'],], 201);
    }
}
