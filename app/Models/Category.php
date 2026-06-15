<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = ['id'];

    // Mutator otomatis membuat slug ketika nama kategori diinput
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    /**
     * Relasi Many-to-Many ke model Book.
     * Satu kategori bisa menampung banyak koleksi buku melalui tabel pivot book_category.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_category');
    }
}
