<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryLog;

class UserController extends Controller
{
    // READ: Menampilkan halaman Dashboard Account Management
    public function index()
    {
        $users = User::latest()->get();
        $totalUsers = $users->count();
        $activeUsers = $users->where('status', 'Active')->count();
        $adminCount = $users->whereIn('access_level', ['admin'])->count();

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
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'position' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan User
        $user = User::create($validatedData);

        // --- CATAT HISTORY ---
        HistoryLog::create([
            'user_id' => Auth::id(), // Siapa admin yang membuat
            'action' => 'Create User',
            'note' => "Created new account for: {$user->first_name} {$user->last_name} ({$user->role})",
            'item_id' => null, // Kosongkan karena bukan barang
            'category_id' => null, // Kosongkan
            'quantity' => 0, // Kosongkan
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    // UPDATE: Menyimpan Perubahan User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
            'position' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8', // Password nullable saat edit
        ]);

        // Logic update password jika diisi
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Simpan perubahan ke variabel dulu untuk cek history
        $oldRole = $user->role;
        $oldPosition = $user->position;

        $user->update($validatedData);

        // --- CATAT HISTORY ---
        // Kita bisa buat note yang detail
        $changes = [];
        if ($oldRole !== $user->role) $changes[] = "Role changed to {$user->role}";
        if ($oldPosition !== $user->position) $changes[] = "Position changed to {$user->position}";

        $note = "Updated details for: {$user->first_name}. " . implode(', ', $changes);

        HistoryLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update User',
            'note' => $note,
            'item_id' => null,
            'category_id' => null,
            'quantity' => 0,
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }
    // DELETE: Menghapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = "{$user->first_name} {$user->last_name}";

        // --- CATAT HISTORY SEBELUM DIHAPUS ---
        HistoryLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete User',
            'note' => "Deleted account: {$userName}",
            'item_id' => null,
            'category_id' => null,
            'quantity' => 0,
        ]);

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
