<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    private  $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        return $this->userService->login($request->all());
    }

    public function validateToken(Request $request)
    {
        // Get the token from the request header
        $token = $request->bearerToken();

        // Check if the token is valid for the authenticated user
        if (Auth::check()) {
            return response()->json([
                'message' => 'Token is valid',
            ]);
        } else {
            return response()->json([
                'message' => 'Token is invalid',
            ], 401);
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
    }
}
