<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // READ: Menampilkan halaman Dashboard Account Management
    public function index()
    {
        $users = User::latest()->get();
        $totalUsers = $users->count();
        $activeUsers = $users->where('status', 'Active')->count();
        $adminCount = $users->whereIn('role', ['Supervisor IT', 'Foreman IT'])->count();

        return view('admin.accountManagement', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'adminCount'
        ));
    }

    // CREATE: Menyimpan User Baru dari Dashboard Admin
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8',
            'role'       => 'required|string',
            'phone'      => 'nullable|string|max:20', 
            'address'    => 'nullable|string', 
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'phone'      => $request->phone,     
            'address'    => $request->address,   
            'status'     => 'Active', 
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan ke sistem!');
    }

    // UPDATE: Menyimpan Perubahan User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'       => 'required|string',
            'phone'      => 'nullable|string|max:20', 
            'address'    => 'nullable|string', 
            'password'   => 'nullable|string|min:8', 
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone = $request->phone;       
        $user->address = $request->address;   

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data user berhasil diperbarui!');
    }

    // DELETE: Menghapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus dari sistem!');
    }
}