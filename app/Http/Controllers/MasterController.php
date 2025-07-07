<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{


    // Redirection vers la page de recherche
    public function search() {

        $allPost = Post::with(['user', 'category'])->get();

        // Récupération des catégories avec le nombre d'articles
        $categories = \App\Models\Category::withCount('posts')->get();

        return view('main.pages.search', compact('categories', 'allPost'));
    }

    // Redirection vers la page des notifications
    public function notifications() {
        $allPost = Post::with(['user', 'category'])->get();

        // Récupération des catégories avec le nombre d'articles
        $categories = \App\Models\Category::withCount('posts')->get();

        return view('main.pages.notifications', compact('categories', 'allPost'));
    }

    // Redirection vers la page des enregistrements
    // public function bookmarks() {

    //     $allPost = Post::with(['user', 'category'])->get();

    //     // Récupération des catégories avec le nombre d'articles
    //     $categories = \App\Models\Category::withCount('posts')->get();

    //     return view('main.pages.bookmarks', compact('categories', 'allPost'));
    // }

    // Redirection vers la page de profil
    public function profil($username) {

        $allPost = Post::with(['user', 'category'])->get();
        $user = User::where('username', $username)->firstOrFail();
        $posts = Post::with(['user', 'category'])
            ->latest()
            ->where('user_id', $user->id)
            ->take(5)
            ->get();

        $postsCount = Post::where('user_id', $user->id)->count();
        $viewsCount = Post::where('user_id', $user->id)->sum('views_count');

        // Récupération des catégories avec le nombre d'articles
        $categories = \App\Models\Category::withCount('posts')->get();

        return view('main.pages.profil', compact('categories', 'allPost', 'user', 'posts', 'postsCount', 'viewsCount'));
    }

    // Redirection vers la page de rédaction
    public function compose() {

        $categories = Category::all();

        return view('main.master-main', compact('categories'));
    }

    /**
     * Charge plus d'articles pour une catégorie donnée (pagination AJAX)
     */
    public function loadMoreArticles(Request $request, $username)
    {
        $page = $request->input('page', 1);
        $user = User::where('username', $username)->firstOrFail();
        $articles = \App\Models\Post::with(['user', 'category'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'page', $page);

        $html = view('partials.postBloc', ['posts' => $articles])->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $articles->hasMorePages(),
            'nextPage' => $articles->currentPage() + 1,
        ]);
    }
}
