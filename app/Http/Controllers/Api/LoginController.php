<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $credentials = [
            'username' => trim($request->username),
            'password' => $request->password
        ];
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'đăng nhập thất bại',
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $request->session()->regenerate();

        $user = User::where('id', auth()->user()->id)->first();
        $token = $user->createToken('accessToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'auth_user' => auth()->user()
        ], Response::HTTP_OK);
    }
}
