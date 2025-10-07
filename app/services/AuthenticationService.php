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
}
