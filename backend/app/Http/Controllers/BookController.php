<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Cache;

// Handle CRUD untuk Book
class BookController extends Controller
{
    // Get daftar buku, pake cache & eager load authornya
    public function index()
    {
        $page = request()->get('page', 1);
        
        // simpan cache buku sejam
        $books = Cache::remember("books_page_{$page}", 3600, function () {
            // load relasi authornya sekalian biar ga N+1
            return Book::with('author')->latest()->paginate(10);
        });
        
        return BookResource::collection($books);
    }

    // Tambah buku baru
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        Cache::flush();
        return new BookResource($book);
    }

    // Detail buku
    public function show(Book $book)
    {
        $book->load('author');
        return new BookResource($book);
    }

    // Update data buku
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        Cache::flush();
        return new BookResource($book);
    }

    // Hapus buku
    public function destroy(Book $book)
    {
        $book->delete();
        Cache::flush();
        return response()->noContent();
    }
}
