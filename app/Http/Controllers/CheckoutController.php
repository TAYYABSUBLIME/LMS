<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Checkout;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($validatedData['book_id']);

        if ($book->copies <= 0) {
            return response()->json(['message' => 'Book not available for checkout'], 400);
        }

        $checkout = Checkout::create([
            'user_id' => $validatedData['user_id'],
            'book_id' => $validatedData['book_id'],
            'checkout_date' => now(),
        ]);

        $book->decrement('copies');

        return response()->json(['message' => 'Book checked out successfully', 'checkout' => $checkout], 201);

    }

    public function returnBook(Request $request, $id)
{
    try {
        $checkout = Checkout::findOrFail($id);

        if ($checkout->return_date !== null) {
            return response()->json(['message' => 'Book already returned'], 400);
        }

        $checkout->update([
            'return_date' => now(),
        ]);

        $book = $checkout->book;
        $book->increment('copies');

        return response()->json(['message' => 'Book returned successfully', 'checkout' => $checkout], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Checkout record not found'], 404);
    } catch (\Exception $e) {
        return response()->json(['message' => 'An error occurred while returning the book'], 500);
    }
}
}
