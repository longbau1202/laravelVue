<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(Request $request) {
        $username = $request->username;
        $password = $request->password;
        
        if (!($username === 'admin') || !($password === 'admin')) {
            return response()->json([
                'user' => $username,
            ], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json([
            'user' => $username,
        ], Response::HTTP_OK);
    }
}
