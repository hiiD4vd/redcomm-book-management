<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Author;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_authors()
    {
        Author::factory()->count(15)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'bio', 'birth_date', 'books_count']
                     ],
                     'meta',
                     'links'
                 ]);
    }

    public function test_can_create_author()
    {
        $payload = [
            'name' => 'John Doe',
            'bio' => 'Test bio',
            'birth_date' => '1990-01-01'
        ];

        $response = $this->postJson('/api/authors', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'John Doe');
                 
        $this->assertDatabaseHas('authors', ['name' => 'John Doe']);
    }

    public function test_cannot_create_author_without_name()
    {
        $payload = [
            'bio' => 'Test bio'
        ];

        $response = $this->postJson('/api/authors', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    public function test_can_update_author()
    {
        $author = Author::factory()->create();

        $payload = [
            'name' => 'Jane Doe updated',
        ];

        $response = $this->putJson("/api/authors/{$author->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Jane Doe updated');

        $this->assertDatabaseHas('authors', ['id' => $author->id, 'name' => 'Jane Doe updated']);
    }

    public function test_can_delete_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
