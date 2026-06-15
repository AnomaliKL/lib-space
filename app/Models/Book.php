<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $guarded = ['id'];

    /**
     * Relasi Many-to-Many ke model Category.
     * Satu buku bisa memiliki banyak kategori melalui tabel penengah book_category.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    /**
     * Relasi One-to-Many ke model Borrowing.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
