<?php
 namespace Tests\Feature;

 use Illuminate\Foundation\Testing\RefreshDatabase;
 use Tests\TestCase;
 use App\Models\User;
 use App\Models\Book;
 use Laravel\Sanctum\Sanctum;

 class CheckoutManagementTest extends TestCase
 {
     use RefreshDatabase;

     public function test_can_checkout_book()
     {
         // Simulate an authenticated user
         Sanctum::actingAs(User::factory()->create());

         // Create a user and a book in the database
         $user = User::factory()->create();
         $book = Book::factory()->create();

         // Send a POST request to the /api/checkout endpoint
         $response = $this->post('/api/checkouts', [
             'user_id' => $user->id,
             'book_id' => $book->id,
         ]);

         // Assert that the response status code is 201
         $response->assertStatus(201);

         // Assert that the response content has the expected message
         $response->assertJson(['message' => 'Book checked out successfully']);
     }

     // Add other test methods for returning books
 }
