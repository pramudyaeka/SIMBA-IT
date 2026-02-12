<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function authenticate(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Cek Kredensial (Login)
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Cek checkbox remember me

        if (Auth::attempt($credentials, $remember)) {
            // Jika berhasil login, regenerate session ID (keamanan)
            $request->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil! Mengalihkan ke dashboard...',
                'redirect_url' => url('/dashboard') // Ganti dengan route dashboard kamu
            ]);
        }

        // 3. Jika Gagal Login
        return response()->json([
            'status' => 'error',
            'message' => 'Email atau password salah.'
        ], 401);
    }

    // Fitur Logout (Bonus)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}