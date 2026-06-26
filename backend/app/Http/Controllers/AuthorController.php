<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Cache;

/**
 * Controller for managing Authors.
 * Handles CRUD operations and API responses for authors.
 */
class AuthorController extends Controller
{
    /**
     * Display a paginated listing of authors.
     * Uses caching to improve performance for frequently accessed pages.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $page = request()->get('page', 1);
        
        // Cache the paginated authors for 60 minutes
        $authors = Cache::remember("authors_page_{$page}", 3600, function () {
            return Author::withCount('books')->latest()->paginate(10);
        });
        
        return AuthorResource::collection($authors);
    }

    /**
     * Store a newly created author in the database.
     * Clears the cache to ensure fresh data is loaded on the next request.
     *
     * @param  \App\Http\Requests\StoreAuthorRequest  $request
     * @return \App\Http\Resources\AuthorResource
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());
        Cache::flush(); // Clear cache when new data is added
        return new AuthorResource($author);
    }

    /**
     * Display the specified author with their associated books.
     *
     * @param  \App\Models\Author  $author
     * @return \App\Http\Resources\AuthorResource
     */
    public function show(Author $author)
    {
        $author->load('books');
        return new AuthorResource($author);
    }

    /**
     * Update the specified author in the database.
     * Clears the cache to reflect updated data.
     *
     * @param  \App\Http\Requests\UpdateAuthorRequest  $request
     * @param  \App\Models\Author  $author
     * @return \App\Http\Resources\AuthorResource
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        Cache::flush(); // Clear cache when data is updated
        return new AuthorResource($author);
    }

    /**
     * Remove the specified author from the database.
     * Clears the cache to remove the deleted author from lists.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        Cache::flush(); // Clear cache when data is deleted
        return response()->noContent();
    }
}
