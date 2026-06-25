<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 10 penulis, masing-masing dengan 3-5 buku
        \App\Models\Author::factory(10)->create()->each(function ($author) {
            \App\Models\Book::factory(rand(3, 5))->create([
                'author_id' => $author->id
            ]);
        });
    }
}
