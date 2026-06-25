# 🎓 LibSpace - Sistem Informasi Perpustakaan Kampus

LibSpace adalah aplikasi manajemen perpustakaan modern berbasis web yang dirancang khusus untuk memenuhi kebutuhan sirkulasi buku fisik maupun reservasi mandiri secara online bagi mahasiswa Teknologi Rekayasa Perangkat Lunak (TRPL).

Aplikasi ini memisahkan hak akses dan pengalaman pengguna secara penuh (*Separation of Concerns*) antara panel administrasi petugas (Admin) dan layanan mandiri mahasiswa (Member).

---

## ✨ Fitur Utama

### 🖥️ Panel Admin (Petugas Perpustakaan)
- **Dashboard Ringkasan:** Statistik real-time total koleksi, sirkulasi buku keluar, permintaan booking aktif, dan denda berjalan.
- **Katalog Master & Kategori:** Manajemen data buku (judul, penulis, deskripsi, stok) terintegrasi dengan relasi *Many-to-Many* pada tabel kategori (pivot table) beserta fitur unggah cover buku.
- **Pencatatan Sirkulasi Langsung:** Form sirkulasi instan di meja petugas menggunakan pencarian anggota dan koleksi berbasis *client-side auto-complete*.
- **Manajemen Antrean Booking:** Validasi dua tahap untuk pemesanan online oleh mahasiswa sebelum pengambilan fisik.
- **Sirkulasi Pengembalian & Denda:** Penghitungan denda keterlambatan berjalan secara real-time (Rp 2.000/hari) dan penguncian nominal denda saat buku fisik dikembalikan.
- **Manajemen Anggota:** Manajemen akun mahasiswa dilengkapi dengan fitur *toggle status* aktif/non-aktif instan.

### 🎓 Area Mahasiswa (Layanan Mandiri Member)
- **Layout Eksklusif & Modern:** Antarmuka bersih bernuansa biru-indigo yang terpisah penuh dari tata letak admin.
- **Katalog Eksploratif:** Fitur *Search Bar* dan filter kategori instan berbasis **Alpine.js** tanpa memicu *reload* halaman.
- **Reservasi Mandiri (Online Booking):** Mahasiswa dapat memesan buku yang tersedia langsung melalui web untuk mengamankan kuota stok sebelum mengambil fisik di perpustakaan.
- **Log Riwayat Sirkulasi:** Memantau status terkini peminjaman (*Menunggu Validasi*, *Siap Diambil*, *Sedang Dipinjam*, *Selesai*) beserta rincian denda personal.

---

## 🛠️ Tech Stack & Arsitektur

- **Framework Utama:** [Laravel 11](https://laravel.com/)
- **Database:** MySQL / PostgreSQL (Mendukung integrasi arsitektur enterprise relasional)
- **Frontend Interactivity:** [Alpine.js](https://alpinejs.dev/) (Untuk pencarian, pengurutan DOM tabel, dan penanganan modal)
- **Styling Engine:** [Tailwind CSS](https://tailwindcss.com/) via CDN / Vite
- **Autentikasi:** Laravel Session Authentication (Secure Route Protection via Middleware)

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

Ikuti langkah-langkah berikut untuk memasang proyek LibSpace di lingkungan lokal kamu:

### 1. Klon Repositori
```bash
git clone [https://github.com/AnomaliKL/libspace.git](https://github.com/AnomaliKL/libspace.git)
cd libspace
