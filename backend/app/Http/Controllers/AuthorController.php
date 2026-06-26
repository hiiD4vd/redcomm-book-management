<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Cache;

// Handle CRUD untuk Author
class AuthorController extends Controller
{
    // Get data authors, sekalian di-cache biar cepet
    public function index()
    {
        $page = request()->get('page', 1);
        
        // set cache sejam
        $authors = Cache::remember("authors_page_{$page}", 3600, function () {
            return Author::withCount('books')->latest()->paginate(10);
        });
        
        return AuthorResource::collection($authors);
    }

    // Insert author baru
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());
        Cache::flush(); // reset cache kalo ada data baru
        return new AuthorResource($author);
    }

    // Get detail author & relasi bukunya
    public function show(Author $author)
    {
        $author->load('books');
        return new AuthorResource($author);
    }

    // Update data author
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        Cache::flush(); // reset cache
        return new AuthorResource($author);
    }

    // Hapus data author
    public function destroy(Author $author)
    {
        $author->delete();
        Cache::flush();
        return response()->noContent();
    }
}
