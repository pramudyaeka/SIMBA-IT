<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // 1. Validasi Manual agar bisa return JSON jika gagal
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'phone'      => 'required|string|max:15',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        // Jika validasi gagal, kirim respon error 422
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Buat User
        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);

        // 3. Return JSON Sukses (Bukan Redirect)
        // Kita kirim URL login di sini agar JS yang melakukan redirect nanti
        return response()->json([
            'status' => 'success',
            'message' => 'Akun berhasil dibuat! Mengalihkan...',
            'redirect_url' => route('login') 
        ], 200);
    }
}