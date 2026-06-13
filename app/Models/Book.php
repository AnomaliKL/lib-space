<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $guarded = ['id'];

    /**
     * Relasi bahwa satu buku bisa memiliki banyak histori peminjaman
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
