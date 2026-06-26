<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Laskar Pelangi',
            'Bumi Manusia',
            'Negeri 5 Menara',
            'Ayat-Ayat Cinta',
            'Perahu Kertas',
            'Ronggeng Dukuh Paruk',
            'Gadis Kretek',
            'Cantik Itu Luka',
            'Pulang',
            'Hujan Bulan Juni',
            'Supernova: Ksatria, Puteri, dan Bintang Jatuh',
            'Orang-Orang Biasa',
        ];

        $descriptions = [
            'Buku ini menceritakan petualangan seru melintasi waktu ke zaman kemerdekaan.',
            'Sebuah panduan komprehensif untuk memahami dasar-dasar pemrograman web modern.',
            'Novel romantis yang menyentuh hati tentang pengorbanan dan cinta tak bersyarat.',
            'Kumpulan cerita pendek yang mengangkat realitas sosial masyarakat perkotaan saat ini.',
            'Buku motivasi yang akan mengubah cara pandang Anda terhadap kegagalan dan kesuksesan.',
            'Investigasi mendalam tentang sejarah tersembunyi yang belum pernah diungkap sebelumnya.',
        ];

        return [
            'title' => fake()->randomElement($titles) . ' ' . fake()->numberBetween(1, 100),
            'author_id' => \App\Models\Author::factory(),
            'description' => fake()->randomElement($descriptions),
            'publish_date' => fake()->date(),
        ];
    }
}
