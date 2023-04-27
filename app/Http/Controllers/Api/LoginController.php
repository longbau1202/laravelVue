<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request) {
        $credentials = [
            'email' => trim($request->username),
            'password' => $request->password
        ];
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'đăng nhập thất bại',
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $request->session()->regenerate();

        $user = User::where('id', auth()->user()->id)->first();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'auth_user' => auth()->user()
        ], Response::HTTP_OK);
    }

    public function logout(Request $request) {
        Auth::logout();
        return response()->json(['message' => 'Đăng xuất thành công'], 200);
    }

    public function register(RegisterRequest $request) {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'permission' => 'member'
        ]);

        if ($user) {
            $credentials = [
                'email' => trim($request->email),
                'password' => $request->password
            ];
            if (auth()->attempt($credentials)) {
                
                $request->session()->regenerate();
    
                $userCreate = User::where('id', auth()->user()->id)->first();
                $token = $userCreate->createToken('api-token')->plainTextToken;
    
                return response()->json([
                    'message' => 'Đăng ký thành công',
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'auth_user' => auth()->user()
                ], Response::HTTP_OK);
            }
        };
        
    }

    public function detail() {
        $user = User::where('id', auth()->user()->id)->first();

        return response()->json([
            'data' => $user
        ]);
    }
}
