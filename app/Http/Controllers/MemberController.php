<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // 1. READ: Menampilkan semua data anggota & menghitung jumlah buku yang sedang dipinjam
    public function index()
    {
        // Mengambil user dengan role 'Member' beserta jumlah peminjaman yang statusnya 'Borrowed'
        $members = User::where('role', 'Member')
            ->withCount(['borrowings as active_borrowings_count' => function ($query) {
                $query->where('status', 'Borrowed');
            }])
            ->latest()
            ->get();

        return view('admin.anggota', compact('members'));
    }

    // 2. CREATE: Menyimpan data anggota baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'member_code' => 'required|unique:users,member_code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'member_code' => $request->member_code,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Member',
            'status' => 'Active',
        ]);

        return redirect()->back()->with('success', 'Anggota baru berhasil ditambahkan!');
    }

    // 3. UPDATE: Memperbarui data profile atau status keaktifan anggota
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'member_code' => 'required|unique:users,member_code,'.$user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $user->update([
            'member_code' => $request->member_code,
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        // Jika admin juga mengedit password
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->back()->with('success', 'Data anggota berhasil diperbarui!');
    }

    // 4. DELETE: Menghapus keanggotaan dari sistem
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus dari sistem!');
    }
}
