<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model buat tabel Authors
class Author extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi pas create/update
    protected $fillable = [
        'name',
        'bio',
        'birth_date',
    ];

    // Relasi ke buku (1 author banyak buku)
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
