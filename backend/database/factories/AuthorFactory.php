<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bios = [
            'Seorang penulis berbakat yang telah menerbitkan berbagai novel laris di Indonesia.',
            'Lahir dan besar di Jakarta. Memiliki ketertarikan kuat pada sastra klasik dan sejarah nusantara.',
            'Penulis lepas yang sering mengisi kolom opini di berbagai surat kabar nasional.',
            'Memulai karir menulisnya sejak usia belia. Karyanya banyak diadaptasi menjadi film layar lebar.',
            'Dikenal dengan gaya penulisannya yang puitis dan selalu mengangkat tema kehidupan sosial sosial.',
            'Seorang pengamat budaya dan penulis buku anak-anak yang telah meraih berbagai penghargaan bergengsi.',
        ];

        return [
            'name' => fake()->name(),
            'bio' => fake()->randomElement($bios),
            'birth_date' => fake()->date('Y-m-d', '2005-01-01'),
        ];
    }
}
