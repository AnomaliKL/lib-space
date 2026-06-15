<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA DUMMY USER (ADMIN & MEMBER)
        User::create([
            'name' => 'Khaikal Iksanuddin',
            'email' => 'khaikal@admin.com',
            'password' => Hash::make('password123'),
            'role' => 'Admin',
            'status' => 'Active',
            'member_code' => null,
        ]);

        User::create([
            'name' => 'Diva Oryza Sativa',
            'email' => 'diva@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Member',
            'status' => 'Active',
            'member_code' => '#USR-001',
        ]);

        User::create([
            'name' => 'Reza Aditya',
            'email' => 'reza@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Member',
            'status' => 'Active',
            'member_code' => '#USR-002',
        ]);

        // 2. DATA DUMMY KATEGORI MASTER
        $catFramework = Category::create([
            'name' => 'Framework',
            'slug' => Str::slug('Framework'),
        ]);

        $catFrontend = Category::create([
            'name' => 'Frontend',
            'slug' => Str::slug('Frontend'),
        ]);

        $catDatabase = Category::create([
            'name' => 'Database',
            'slug' => Str::slug('Database'),
        ]);

        // 3. DATA DUMMY BUKU (TANPA COLUMN category_id)
        $book1 = Book::create([
            'title' => 'Belajar Laravel 11 Pemula sampai Mahir',
            'author' => 'Ahmad Fauzi',
            'stock' => 3,
        ]);
        // Menghubungkan book1 ke kategori Framework via Tabel Pivot
        $book1->categories()->attach([$catFramework->id]);

        $book2 = Book::create([
            'title' => 'Mastering React & Tailwind CSS',
            'author' => 'Siti Rahma',
            'stock' => 2,
        ]);
        // Menghubungkan book2 ke dua kategori sekaligus (Frontend & Framework)
        $book2->categories()->attach([$catFrontend->id, $catFramework->id]);

        $book3 = Book::create([
            'title' => 'SQL & PostgreSQL Fundamentals',
            'author' => 'Rian Hidayat',
            'stock' => 0,
        ]);
        // Menghubungkan book3 ke kategori Database
        $book3->categories()->attach([$catDatabase->id]);

        // 4. DATA DUMMY TRANSAKSI (BORROWINGS)
        Borrowing::create([
            'user_id' => 2,
            'book_id' => 1,
            'borrow_date' => '2026-06-10',
            'return_deadline' => '2026-06-17',
            'status' => 'Borrowed',
        ]);

        Borrowing::create([
            'user_id' => 3,
            'book_id' => 1,
            'return_deadline' => '2026-06-14',
            'status' => 'Booking',
        ]);
    }
}
