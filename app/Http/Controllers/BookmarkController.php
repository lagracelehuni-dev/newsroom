<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/BookmarkController.php
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();

        if ($user->bookmarks()->where('post_id', $post->id)->exists()) {
            $user->bookmarks()->detach($post);
            return response()->json([
                'bookmarked' => false,
                'success' => true,
                'message' => 'Article retiré des enregistrements avec succès !'
            ]);
        } else {
            $user->bookmarks()->attach($post);
            return response()->json([
                'bookmarked' => true,
                'success' => true,
                'message' => 'Article enregistré avec succès !'
            ]);
        }
    }

    public function index()
    {
        $bookmarkedPosts = Auth::user()
            ->bookmarks()
            ->with(['user', 'category']) // Chargement eager
            ->latest()
            ->paginate(10);

        $allPost = Post::with(['user', 'category'])->get();

        // Récupération des catégories avec le nombre d'articles
        $categories = \App\Models\Category::withCount('posts')->get();

        return view('main.pages.bookmarks', compact('bookmarkedPosts', 'allPost', 'categories'));
    }
}

