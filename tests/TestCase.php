<?php
namespace Tests;
 use Illuminate\Foundation\Testing\RefreshDatabase;

 use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
 use Laravel\Sanctum\Sanctum; // Import the Sanctum facade

 use App\Models\User;
 use Tests\CreatesApplication;

 abstract class TestCase extends BaseTestCase
 {
     use CreatesApplication, RefreshDatabase;

     protected function setUp(): void
     {
         parent::setUp();

         // Configure Sanctum for testing
         Sanctum::actingAs(
             User::factory()->create(),
             ['*']
         );
     }
 }
?>
