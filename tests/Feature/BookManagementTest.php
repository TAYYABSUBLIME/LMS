<?php
namespace Tests\Feature;
use Tests\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_get_all_books()
    {
        Sanctum::actingAs(User::factory()->create());

        // Create some dummy books in the database
        Book::factory()->count(3)->create();

        // Send a GET request to the /api/books endpoint
        $response = $this->get('/api/books');

        // Assert that the response status code is 200
        $response->assertStatus(200);

        // Assert that the response content has the expected structure
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'author',
                'isbn',
                'published_at',
                'copies',
                'created_at',
                'updated_at',
            ]
        ]);
    }


    // Add other test methods for adding, updating, and deleting books
}
