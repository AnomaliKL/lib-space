<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. DATA DUMMY USER (ADMIN & MEMBER)

        // Akun Admin Utama
        User::create([
            'name' => 'Khaikal Iksanuddin',
            'email' => 'khaikal@admin.com',
            'password' => Hash::make('password123'),
            'role' => 'Admin',
            'status' => 'Active',
            'member_code' => null,
        ]);

        // Akun Member 1
        User::create([
            'name' => 'Diva Oryza Sativa',
            'email' => 'diva@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Member',
            'status' => 'Active',
            'member_code' => '#USR-001',
        ]);

        // Akun Member 2
        User::create([
            'name' => 'Reza Aditya',
            'email' => 'reza@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Member',
            'status' => 'Active',
            'member_code' => '#USR-002',
        ]);

        // Akun Member 3
        User::create([
            'name' => 'Siva Aprillia',
            'email' => 'siva@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Member',
            'status' => 'Active',
            'member_code' => '#USR-003',
        ]);

        // Akun Member 4
        User::create([
            'name' => 'Helgi Destian',
            'email' => 'helgi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Member',
            'status' => 'Active',
            'member_code' => '#USR-004',
        ]);

        // 2. DATA DUMMY BUKU (BOOKS)

        $book1 = Book::create([
            'title' => 'Belajar Laravel 11 Pemula sampai Mahir',
            'author' => 'Ahmad Fauzi',
            'category' => 'Framework',
            'stock' => 3,
        ]);

        $book2 = Book::create([
            'title' => 'Mastering React & Tailwind CSS',
            'author' => 'Siti Rahma',
            'category' => 'Frontend',
            'stock' => 2,
        ]);

        $book3 = Book::create([
            'title' => 'SQL & PostgreSQL Fundamentals',
            'author' => 'Rian Hidayat',
            'category' => 'Database',
            'stock' => 0, // Sengaja diset kosong untuk simulasi habis
        ]);

        // 3. DATA DUMMY TRANSAKSI (BORROWINGS)

        // Transaksi 1: Diva sedang meminjam buku fisik (Borrowed)
        Borrowing::create([
            'user_id' => 2, // ID milik Diva
            'book_id' => 1, // ID buku Laravel
            'borrow_date' => '2026-06-10',
            'return_deadline' => '2026-06-17',
            'returned_at' => null,
            'fine' => 0,
            'status' => 'Borrowed',
        ]);

        // Transaksi 2: Reza sedang melakukan Booking online lewat Web (Booking)
        Borrowing::create([
            'user_id' => 3, // ID milik Reza
            'book_id' => 1, // ID buku Laravel
            'borrow_date' => null,
            'return_deadline' => '2026-06-14', // Batas ambil besok
            'returned_at' => null,
            'fine' => 0,
            'status' => 'Booking',
        ]);

        // Transaksi 3: Siva sudah selesai mengembalikan buku dengan tepat waktu (Returned)
        Borrowing::create([
            'user_id' => 4, // ID milik Siva
            'book_id' => 2, // ID buku React
            'borrow_date' => '2026-06-05',
            'return_deadline' => '2026-06-12',
            'returned_at' => '2026-06-11', // Dikembalikan sehari sebelum deadline
            'fine' => 0,
            'status' => 'Returned',
        ]);

        // Transaksi 4: Helgi terlambat mengembalikan buku (Simulasi Denda)
        Borrowing::create([
            'user_id' => 5, // ID milik Helgi
            'book_id' => 3, // ID buku SQL
            'borrow_date' => '2026-06-01',
            'return_deadline' => '2026-06-08',
            'returned_at' => '2026-06-13', // Dikembalikan telat 5 hari
            'fine' => 10000, // Denda Rp 10.000 (misal per hari Rp 2.000)
            'status' => 'Returned',
        ]);
    }
}
