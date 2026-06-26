<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Author;
use App\Models\Book;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_books()
    {
        Book::factory()->count(15)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'description', 'publish_date', 'author']
                     ],
                     'meta',
                     'links'
                 ]);
    }

    public function test_can_create_book()
    {
        $author = Author::factory()->create();

        $payload = [
            'title' => 'Test Book',
            'author_id' => $author->id,
            'description' => 'Test description',
            'publish_date' => '2020-01-01'
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.title', 'Test Book');
                 
        $this->assertDatabaseHas('books', ['title' => 'Test Book', 'author_id' => $author->id]);
    }

    public function test_cannot_create_book_without_author()
    {
        $payload = [
            'title' => 'Test Book',
            'description' => 'Test description'
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['author_id']);
    }

    public function test_can_update_book()
    {
        $book = Book::factory()->create();
        $newAuthor = Author::factory()->create();

        $payload = [
            'title' => 'Updated Book Title',
            'author_id' => $newAuthor->id
        ];

        $response = $this->putJson("/api/books/{$book->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonPath('data.title', 'Updated Book Title');

        $this->assertDatabaseHas('books', [
            'id' => $book->id, 
            'title' => 'Updated Book Title',
            'author_id' => $newAuthor->id
        ]);
    }

    public function test_can_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
