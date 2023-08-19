<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{

    public function index()
    {

        $books = Book::all();

        if ($books->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json($books, 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'required|string|max:50|unique:books',
                'published_at' => 'required|date_format:Y-m-d',
                'copies' => 'required|integer|min:1',
            ]);

            $book = Book::create($validatedData);

            return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while creating the book'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'required|string|max:50|unique:books,isbn,' . $id,
                'published_at' => 'required|date_format:Y-m-d',
                // Adjust date format
                'copies' => 'required|integer|min:1',
            ]);

            $book->update($validatedData);

            return response()->json(['message' => 'Book updated successfully', 'book' => $book], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the book'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the book'], 500);
        }
    }


}
