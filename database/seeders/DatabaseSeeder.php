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
        // ==========================================
        // 1. DATA DUMMY USER (1 ADMIN + 35 MEMBER)
        // ==========================================
        User::create([
            'name' => 'Khaikal Iksanuddin',
            'email' => 'khaikal@admin.com',
            'password' => Hash::make('password123'),
            'role' => 'Admin',
            'status' => 'Active',
            'member_code' => null,
        ]);

        $u1 = User::create(['name' => 'Diva Oryza Sativa', 'email' => 'diva@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-001']);
        $u2 = User::create(['name' => 'Reza Aditya', 'email' => 'reza@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-002']);
        $u3 = User::create(['name' => 'Siva Putri', 'email' => 'siva@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-003']);
        $u4 = User::create(['name' => 'Helgi Pratama', 'email' => 'helgi@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-004']);
        $u5 = User::create(['name' => 'Kekey Aulia', 'email' => 'kekey@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-005']);
        $u6 = User::create(['name' => 'Ahmad Fauzi', 'email' => 'ahmad@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-006']);
        $u7 = User::create(['name' => 'Siti Rahma', 'email' => 'siti@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-007']);
        $u8 = User::create(['name' => 'Rian Hidayat', 'email' => 'rian@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-008']);
        $u9 = User::create(['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-009']);
        $u10 = User::create(['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-010']);
        $u11 = User::create(['name' => 'Fahmi Ramadhan', 'email' => 'fahmi@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-011']);
        $u12 = User::create(['name' => 'Gita Permata', 'email' => 'gita@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-012']);
        $u13 = User::create(['name' => 'Hendra Wijaya', 'email' => 'hendra@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-013']);
        $u14 = User::create(['name' => 'Indah Sari', 'email' => 'indah@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-014']);
        $u15 = User::create(['name' => 'Joko Susilo', 'email' => 'joko@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-015']);
        $u16 = User::create(['name' => 'Kurnia Ningrum', 'email' => 'kurnia@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-016']);
        $u17 = User::create(['name' => 'Lesti Kejora', 'email' => 'lesti@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-017']);
        $u18 = User::create(['name' => 'Maman Suparman', 'email' => 'maman@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-018']);
        $u19 = User::create(['name' => 'Novianti Putri', 'email' => 'novi@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-019']);
        $u20 = User::create(['name' => 'Oki Setiawan', 'email' => 'oki@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-020']);
        $u21 = User::create(['name' => 'Putra Pratama', 'email' => 'putra@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-021']);
        $u22 = User::create(['name' => 'Qori Amelia', 'email' => 'qori@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-022']);
        $u23 = User::create(['name' => 'Rizky Billar', 'email' => 'rizky@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-023']);
        $u24 = User::create(['name' => 'Sinta Bella', 'email' => 'sinta@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-024']);
        $u25 = User::create(['name' => 'Taufik Hidayat', 'email' => 'taufik@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-025']);
        $u26 = User::create(['name' => 'Ulfa Fitriani', 'email' => 'ulfa@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-026']);
        $u27 = User::create(['name' => 'Vino Bastian', 'email' => 'vino@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-027']);
        $u28 = User::create(['name' => 'Winda Basudara', 'email' => 'winda@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-028']);
        $u29 = User::create(['name' => 'Xavier Malik', 'email' => 'xavier@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-029']);
        $u30 = User::create(['name' => 'Yayan Ruhian', 'email' => 'yayan@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-030']);
        $u31 = User::create(['name' => 'Zack Lee', 'email' => 'zack@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-031']);
        $u32 = User::create(['name' => 'Aditya Wijaya', 'email' => 'adit@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-032']);
        $u33 = User::create(['name' => 'Bella Citra', 'email' => 'bella@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-033']);
        $u34 = User::create(['name' => 'Chandra Malik', 'email' => 'chandra@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-034']);
        $u35 = User::create(['name' => 'Dani Saputra', 'email' => 'dani@example.com', 'password' => Hash::make('password123'), 'role' => 'Member', 'status' => 'Active', 'member_code' => '#USR-035']);

        // ==========================================
        // 2. DATA DUMMY KATEGORI MASTER (10 KATEGORI)
        // ==========================================
        $c1 = Category::create(['name' => 'Framework', 'slug' => Str::slug('Framework')]);
        $c2 = Category::create(['name' => 'Frontend', 'slug' => Str::slug('Frontend')]);
        $c3 = Category::create(['name' => 'Database', 'slug' => Str::slug('Database')]);
        $c4 = Category::create(['name' => 'Backend', 'slug' => Str::slug('Backend')]);
        $c5 = Category::create(['name' => 'Mobile Development', 'slug' => Str::slug('Mobile Development')]);
        $c6 = Category::create(['name' => 'UI UX Design', 'slug' => Str::slug('UI UX Design')]);
        $c7 = Category::create(['name' => 'Machine Learning', 'slug' => Str::slug('Machine Learning')]);
        $c8 = Category::create(['name' => 'Cyber Security', 'slug' => Str::slug('Cyber Security')]);
        $c9 = Category::create(['name' => 'DevOps', 'slug' => Str::slug('DevOps')]);
        $c10 = Category::create(['name' => 'Game Development', 'slug' => Str::slug('Game Development')]);

        // Unsplash cover sample
        $cover1 = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop';
        $cover2 = 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=500&auto=format&fit=crop';
        $cover3 = 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=500&auto=format&fit=crop';
        $cover4 = 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&auto=format&fit=crop';

        // ==========================================
        // 3. DATA DUMMY BUKU MASTER (32 BUKU)
        // ==========================================
        $b1 = Book::create(['title' => 'Belajar Laravel 11 Pemula sampai Mahir', 'author' => 'Ahmad Fauzi', 'cover_url' => $cover1, 'description' => 'Panduan lengkap membangun aplikasi web modern berskala enterprise menggunakan framework Laravel 11.', 'stock' => 3]);
        $b1->categories()->attach([$c1->id, $c4->id]);

        $b2 = Book::create(['title' => 'Mastering React & Tailwind CSS', 'author' => 'Siti Rahma', 'cover_url' => $cover2, 'description' => 'Kombinasi terbaik untuk frontend developer membangun UI reaktif.', 'stock' => 2]);
        $b2->categories()->attach([$c2->id, $c1->id]);

        $b3 = Book::create(['title' => 'SQL & PostgreSQL Fundamentals', 'author' => 'Rian Hidayat', 'cover_url' => $cover3, 'description' => 'Kuasai konsep dasar database relasional dan optimasi query kompleks.', 'stock' => 4]);
        $b3->categories()->attach([$c3->id]);

        $b4 = Book::create(['title' => 'Vue.js 3 Express Guide', 'author' => 'Sandhika Galih', 'cover_url' => $cover4, 'description' => 'Panduan praktis SPA frontend modern dengan Vue 3.', 'stock' => 3]);
        $b4->categories()->attach([$c2->id]);

        $b5 = Book::create(['title' => 'Building RESTful API with Node.js', 'author' => 'Eko Khannedy', 'cover_url' => $cover1, 'description' => 'Konsep backend service cepat menggunakan Javascript runtime.', 'stock' => 2]);
        $b5->categories()->attach([$c4->id]);

        $b6 = Book::create(['title' => 'Flutter Hybrid Mobile Apps', 'author' => 'Ahmad Fauzi', 'cover_url' => $cover2, 'description' => 'Satu codebase untuk Android dan iOS menggunakan Dart SDK.', 'stock' => 5]);
        $b6->categories()->attach([$c5->id]);

        $b7 = Book::create(['title' => 'UI/UX Design Fundamental with Figma', 'author' => 'Siti Rahma', 'cover_url' => $cover3, 'description' => 'Rancangan wireframe, prototyping, hingga handoff design.', 'stock' => 3]);
        $b7->categories()->attach([$c6->id]);

        $b8 = Book::create(['title' => 'Python for Machine Learning', 'author' => 'Rian Hidayat', 'cover_url' => $cover4, 'description' => 'Implementasi Scikit-Learn dan Pandas untuk pemrosesan data intelijen.', 'stock' => 0]);
        $b8->categories()->attach([$c7->id]);

        $b9 = Book::create(['title' => 'Ethical Hacking & Cyber Security', 'author' => 'Eko Khannedy', 'cover_url' => $cover1, 'description' => 'Materi keamanan jaringan, penetration testing, dan defenisi malware.', 'stock' => 2]);
        $b9->categories()->attach([$c8->id]);

        $b10 = Book::create(['title' => 'Docker & Kubernetes Containerization', 'author' => 'Sandhika Galih', 'cover_url' => $cover2, 'description' => 'Orkestrasi microservices modern skala production cloud.', 'stock' => 4]);
        $b10->categories()->attach([$c9->id]);

        $b11 = Book::create(['title' => 'Unity 3D Game Development development', 'author' => 'Ahmad Fauzi', 'cover_url' => $cover3, 'description' => 'Membangun game low-poly 3D dari basic script C#.', 'stock' => 2]);
        $b11->categories()->attach([$c10->id]);

        $b12 = Book::create(['title' => 'Advanced Eloquent Laravel Tips', 'author' => 'Khaikal Tech', 'cover_url' => $cover4, 'description' => 'Optimasi query n+1 problem, morphic relation, dan lazy loading.', 'stock' => 3]);
        $b12->categories()->attach([$c1->id]);

        $b13 = Book::create(['title' => 'Next.js 14 Production Ready', 'author' => 'Diva Oryza', 'cover_url' => $cover1, 'description' => 'Server-side rendering dan static site generation dengan React framework.', 'stock' => 2]);
        $b13->categories()->attach([$c1->id, $c2->id]);

        $b14 = Book::create(['title' => 'Redis Caching Deep Dive', 'author' => 'Reza Code', 'cover_url' => $cover2, 'description' => 'Mempercepat query database dengan in-memory data structure store.', 'stock' => 3]);
        $b14->categories()->attach([$c3->id, $c4->id]);

        $b15 = Book::create(['title' => 'GoLang Microservices Architecture', 'author' => 'Eko Khannedy', 'cover_url' => $cover3, 'description' => 'Membangun REST API berkecepatan tinggi dengan konkurensi Go.', 'stock' => 5]);
        $b15->categories()->attach([$c4->id]);

        $b16 = Book::create(['title' => 'Tailwind CSS Component Master', 'author' => 'Sandhika Galih', 'cover_url' => $cover4, 'description' => 'Slicing layout figma ke utility-first CSS dengan cepat.', 'stock' => 3]);
        $b16->categories()->attach([$c2->id]);

        $b17 = Book::create(['title' => 'Kotlin for Android Native', 'author' => 'Ahmad Fauzi', 'cover_url' => $cover1, 'description' => 'Development mobile app aman dan ekspresif menggantikan Java.', 'stock' => 1]);
        $b17->categories()->attach([$c5->id]);

        $b18 = Book::create(['title' => 'Figma Prototyping Advanced', 'author' => 'Siti Rahma', 'cover_url' => $cover2, 'description' => 'Membuat micro-interaction komponen UI yang interaktif.', 'stock' => 4]);
        $b18->categories()->attach([$c6->id]);

        $b19 = Book::create(['title' => 'Deep Learning with TensorFlow', 'author' => 'Rian Hidayat', 'cover_url' => $cover3, 'description' => 'Pengenalan Neural Networks untuk klasifikasi gambar kompleks.', 'stock' => 2]);
        $b19->categories()->attach([$c7->id]);

        $b20 = Book::create(['title' => 'Linux Server Administration Fundamentals', 'author' => 'Khaikal Tech', 'cover_url' => $cover4, 'description' => 'Manajemen user, bash scripting, cronjobs, dan firewall server.', 'stock' => 3]);
        $b20->categories()->attach([$c9->id]);

        $b21 = Book::create(['title' => 'Godot Engine 4 Game Programming', 'author' => 'Reza Code', 'cover_url' => $cover1, 'description' => 'Penggunaan GDScript untuk game survival 2D dan 3D.', 'stock' => 2]);
        $b21->categories()->attach([$c10->id]);

        $b22 = Book::create(['title' => 'MySQL Indexing Optimization', 'author' => 'Rian Hidayat', 'cover_url' => $cover2, 'description' => 'Cara mempercepat query jutaan baris data dengan indeks yang tepat.', 'stock' => 3]);
        $b22->categories()->attach([$c3->id]);

        $b23 = Book::create(['title' => 'TypeScript Clean Code Guidelines', 'author' => 'Diva Oryza', 'cover_url' => $cover3, 'description' => 'Kombinasi static typing untuk merancang aplikasi Javascript skala besar.', 'stock' => 4]);
        $b23->categories()->attach([$c2->id, $c4->id]);

        $b24 = Book::create(['title' => 'CI/CD Pipelines with GitHub Actions', 'author' => 'Khaikal Tech', 'cover_url' => $cover4, 'description' => 'Otomatisasi pengujian, build kontainer, hingga autodeploy Railway.', 'stock' => 2]);
        $b24->categories()->attach([$c9->id]);

        $b25 = Book::create(['title' => 'GraphQL API vs REST Best Practice', 'author' => 'Eko Khannedy', 'cover_url' => $cover1, 'description' => 'Studi komparasi efisiensi data fetching data untuk frontend.', 'stock' => 3]);
        $b25->categories()->attach([$c4->id]);

        $b26 = Book::create(['title' => 'Django Python Framework Guide', 'author' => 'Rian Hidayat', 'cover_url' => $cover2, 'description' => 'Membangun monolith web app cepat dengan built-in admin panel.', 'stock' => 3]);
        $b26->categories()->attach([$c1->id, $c4->id]);

        $b27 = Book::create(['title' => 'Nuxt.js Fullstack Deployment', 'author' => 'Sandhika Galih', 'cover_url' => $cover3, 'description' => 'SSR framework pendukung engine Vue untuk optimasi SEO.', 'stock' => 2]);
        $b27->categories()->attach([$c1->id, $c2->id]);

        $b28 = Book::create(['title' => 'MongoDB NoSQL Document Store', 'author' => 'Reza Code', 'cover_url' => $cover4, 'description' => 'Skema data fleksibel berbasis JSON untuk penampung log aplikasi.', 'stock' => 4]);
        $b28->categories()->attach([$c3->id]);

        $b29 = Book::create(['title' => 'React Native Cross Platform', 'author' => 'Diva Oryza', 'cover_url' => $cover1, 'description' => 'Membangun aplikasi mobile aseli dengan basis Javascript React.', 'stock' => 3]);
        $b29->categories()->attach([$c5->id, $c1->id]);

        $b30 = Book::create(['title' => 'API Security and OAuth2 Guide', 'author' => 'Khaikal Tech', 'cover_url' => $cover2, 'description' => 'Pengamanan endpoint dengan JWT token dan protokol otorisasi.', 'stock' => 2]);
        $b30->categories()->attach([$c8->id]);

        $b31 = Book::create(['title' => 'Blender 3D Modeling lowpoly', 'author' => 'Siti Rahma', 'cover_url' => $cover3, 'description' => 'Teknik dasar modeling mesh, texturing, untuk aset digital game.', 'stock' => 3]);
        $b31->categories()->attach([$c6->id, $c10->id]);

        $b32 = Book::create(['title' => 'Ansible Automation Server Configuration', 'author' => 'Khaikal Tech', 'cover_url' => $cover4, 'description' => 'Manajemen konfigurasi infratruktur server berbasis deklaratif playbook.', 'stock' => 2]);
        $b32->categories()->attach([$c9->id]);

        // ==========================================
        // 4. DATA DUMMY TRANSAKSI SIRKULASI (30 DATA)
        // ==========================================
        Borrowing::create(['user_id' => $u1->id, 'book_id' => $b1->id, 'borrow_date' => '2026-06-01', 'return_deadline' => '2026-06-08', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u2->id, 'book_id' => $b2->id, 'borrow_date' => '2026-06-02', 'return_deadline' => '2026-06-09', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u3->id, 'book_id' => $b3->id, 'borrow_date' => '2026-06-03', 'return_deadline' => '2026-06-10', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u4->id, 'book_id' => $b4->id, 'borrow_date' => '2026-06-04', 'return_deadline' => '2026-06-11', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u5->id, 'book_id' => $b5->id, 'borrow_date' => '2026-06-05', 'return_deadline' => '2026-06-12', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u6->id, 'book_id' => $b6->id, 'borrow_date' => '2026-06-06', 'return_deadline' => '2026-06-13', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u7->id, 'book_id' => $b7->id, 'borrow_date' => '2026-06-07', 'return_deadline' => '2026-06-14', 'status' => 'Borrowed']);

        // Data Booking Online
        Borrowing::create(['user_id' => $u8->id, 'book_id' => $b8->id, 'return_deadline' => '2026-06-18', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u9->id, 'book_id' => $b9->id, 'return_deadline' => '2026-06-19', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u10->id, 'book_id' => $b10->id, 'return_deadline' => '2026-06-20', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u11->id, 'book_id' => $b11->id, 'return_deadline' => '2026-06-21', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u12->id, 'book_id' => $b12->id, 'return_deadline' => '2026-06-22', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u13->id, 'book_id' => $b13->id, 'return_deadline' => '2026-06-23', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u14->id, 'book_id' => $b14->id, 'return_deadline' => '2026-06-24', 'status' => 'Booking']);

        // Sisa Transaksi Campuran Manual
        Borrowing::create(['user_id' => $u15->id, 'book_id' => $b15->id, 'borrow_date' => '2026-06-08', 'return_deadline' => '2026-06-15', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u16->id, 'book_id' => $b16->id, 'borrow_date' => '2026-06-08', 'return_deadline' => '2026-06-15', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u17->id, 'book_id' => $b17->id, 'borrow_date' => '2026-06-09', 'return_deadline' => '2026-06-16', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u18->id, 'book_id' => $b18->id, 'borrow_date' => '2026-06-09', 'return_deadline' => '2026-06-16', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u19->id, 'book_id' => $b19->id, 'borrow_date' => '2026-06-10', 'return_deadline' => '2026-06-17', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u20->id, 'book_id' => $b20->id, 'borrow_date' => '2026-06-10', 'return_deadline' => '2026-06-17', 'status' => 'Borrowed']);

        Borrowing::create(['user_id' => $u21->id, 'book_id' => $b21->id, 'return_deadline' => '2026-06-25', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u22->id, 'book_id' => $b22->id, 'return_deadline' => '2026-06-25', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u23->id, 'book_id' => $b23->id, 'return_deadline' => '2026-06-26', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u24->id, 'book_id' => $b24->id, 'return_deadline' => '2026-06-26', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u25->id, 'book_id' => $b25->id, 'return_deadline' => '2026-06-27', 'status' => 'Booking']);

        Borrowing::create(['user_id' => $u26->id, 'book_id' => $b26->id, 'borrow_date' => '2026-06-11', 'return_deadline' => '2026-06-18', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u27->id, 'book_id' => $b27->id, 'borrow_date' => '2026-06-11', 'return_deadline' => '2026-06-18', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u28->id, 'book_id' => $b28->id, 'borrow_date' => '2026-06-12', 'return_deadline' => '2026-06-19', 'status' => 'Borrowed']);
        Borrowing::create(['user_id' => $u29->id, 'book_id' => $b29->id, 'return_deadline' => '2026-06-28', 'status' => 'Booking']);
        Borrowing::create(['user_id' => $u30->id, 'book_id' => $b30->id, 'return_deadline' => '2026-06-28', 'status' => 'Booking']);
    }
}
