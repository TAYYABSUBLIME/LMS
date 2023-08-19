<?php

 use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\UserController;
 use App\Http\Controllers\BookController;
 use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// User Authentication
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// Protected routes that require authentication via Sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    // CRUD operations for Books
    Route::get('books', [BookController::class, 'index']);
    Route::post('books', [BookController::class, 'store']);
    Route::patch('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);

    // Checking Out and Returning Books
    Route::post('checkouts', [CheckoutController::class, 'checkout']);
    Route::put('checkouts/{id}', [CheckoutController::class, 'returnBook']);
});
