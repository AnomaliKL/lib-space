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

    // 3. UPDATE: Memperbarui data profile anggota (Tanpa input status lagi)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'member_code' => 'required|unique:users,member_code,'.$user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'member_code' => $request->member_code,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Jika admin juga mengedit password
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->back()->with('success', 'Data profile anggota berhasil diperbarui!');
    }

    // 🔥 NEW ACTION: Mengubah status keaktifan anggota (Toggle Active/Inactive)
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Balikkan status: Jika Active jadi Inactive, jika Inactive jadi Active
        $user->status = ($user->status === 'Active') ? 'Inactive' : 'Active';
        $user->save();

        $message = $user->status === 'Active'
            ? "Anggota bernama {$user->name} berhasil diaktifkan kembali!"
            : "Anggota bernama {$user->name} telah dinonaktifkan!";

        return redirect()->back()->with('success', $message);
    }

    // 4. DELETE: Menghapus keanggotaan dari sistem (Hanya jika berstatus Inactive)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Keamanan Tambahan: Mencegah penghapusan jika user masih aktif
        if ($user->status === 'Active') {
            return redirect()->back()->with('error', 'Gagal! Anggota harus dinonaktifkan terlebih dahulu sebelum dihapus.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus permanen dari sistem!');
    }
}
