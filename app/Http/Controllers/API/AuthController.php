<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        // Validasi data yang diterima dari request
        $validasi = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'confirm_password' => 'required|string',
        ]);

        if ($validasi['password'] !== $validasi['confirm_password']) {
            return response()->json([
                "code" => 203,
                "message" => "Kata sandi tidak sama dengan konfirmasi kata sandi.",
            ]);
        }

        // Enkripsi password sebelum menyimpannya
        $validasi['password'] = Hash::make($validasi['password']);
        $validasi['confirm_password'] = Hash::make($validasi['confirm_password']);

        $data = User::create($validasi);

        return response()->json([
            "code" => 200,
            "message" => "Berhasil Membuat Akun baru",
            "data" => $data,
        ]);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }


    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
