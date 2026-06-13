<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    // Mengizinkan semua kolom diisi massal saat seeding/input
    protected $guarded = ['id'];

    /**
     * Relasi ke model User (Anggota yang meminjam)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Book (Buku yang dipinjam)
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
