<?php

namespace App\Http\Controllers;
use App\User;
use App\ProfilToko;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
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
    
        $data = User::create($validasi);
    
        return response()->json([
            "code" => 200,
            "message" => "Berhasil Membuat Akun baru",
            "data" => $data,
        ]);
    }

    public function createStore(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'nama_toko' => 'required|string',
            'nomor_telepon' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        $profilToko = $user->profilToko()->create($validatedData);

        return response()->json([
            'code' => 200,
            'message' => 'Profil Toko berhasil dibuat',
            'data' => $profilToko,
        ]);
    }

    public function data (){
        $data = User::all();

        return response()->json([
            "code" => 200,
            "message" => "list data user",
            "data" => $data,
        ]);
    }

    public function getDataWithProfile($userId)
    {
        $user = User::find($userId);
    
        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'User tidak ditemukan',
            ], 404);
        }
    
        $profilToko = $user->profilToko;
    
        if (!$profilToko) {
            return response()->json([
                'code' => 404,
                'message' => 'Profil Toko tidak ditemukan untuk user ini',
            ], 404);
        }
    
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil mendapatkan data Profil Toko',
            'user' => $user,
        ]);
    }    
    
    
}
