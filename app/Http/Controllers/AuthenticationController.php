<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|email',
                'password' => 'required'
            ]);

            $authService = new AuthenticationService();
            $result = $authService->authenticate($request->email, $request->password);
            return $result;
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during authentication', 'message' => $e->getMessage()], 500);
        }
    }

    public function registerUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $authService = new AuthenticationService();
            $result = $authService->registerUser($request->all());
            return $result;
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during user registration', 'message' => $e->getMessage()], 500);
        }
    }
}
