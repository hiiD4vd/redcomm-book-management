<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model buat tabel Books
class Book extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi pas create/update
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'publish_date',
    ];

    // Relasi ke tabel authors (1 buku punya 1 author)
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
