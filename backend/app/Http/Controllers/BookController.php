<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Cache;

/**
 * Controller for managing Books.
 * Handles CRUD operations and API responses for books.
 */
class BookController extends Controller
{
    /**
     * Display a paginated listing of books.
     * Uses eager loading to prevent N+1 query problems and caching for performance.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $page = request()->get('page', 1);
        
        // Cache the paginated books for 60 minutes
        $books = Cache::remember("books_page_{$page}", 3600, function () {
            // Eager load author to prevent N+1 query problem, paginate the results
            return Book::with('author')->latest()->paginate(10);
        });
        
        return BookResource::collection($books);
    }

    /**
     * Store a newly created book in the database.
     * Clears the cache to ensure fresh data is loaded on the next request.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \App\Http\Resources\BookResource
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        Cache::flush();
        return new BookResource($book);
    }

    /**
     * Display the specified book with its associated author.
     *
     * @param  \App\Models\Book  $book
     * @return \App\Http\Resources\BookResource
     */
    public function show(Book $book)
    {
        $book->load('author');
        return new BookResource($book);
    }

    /**
     * Update the specified book in the database.
     * Clears the cache to reflect updated data.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \App\Http\Resources\BookResource
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        Cache::flush();
        return new BookResource($book);
    }

    /**
     * Remove the specified book from the database.
     * Clears the cache to remove the deleted book from lists.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        Cache::flush();
        return response()->noContent();
    }
}
