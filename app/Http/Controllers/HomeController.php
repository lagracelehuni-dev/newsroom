<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{

    /**
     * Affiche la page d'accueil avec des articles aléatoires
     */
    public function home()
    {
        // Gestion de la première visite
        if (!session()->has('visited')) {
            session()->put('visited', true);
            session()->flash('show_welcome', true);
        }

        // Récupération des articles depuis la base avec relations
        $posts = Post::with(['user', 'category', 'bookmarks'])
            ->orderBy('views_count', 'desc') // Trier par le nombre de vues
            ->latest()
            ->take(5)
            ->get();

        $allPost = Post::with(['user', 'category'])->get();

        // Récupération des catégories avec le nombre d'articles
        $categories = \App\Models\Category::withCount('posts')->get();

        return view('main.pages.categoryPage.allCategories', compact('posts', 'categories', 'allPost'));
    }

    /**
     * Marque les félicitations comme lues pour un utilisateur
     */
    public function closeCongrats($id)
    {
        User::where('id', $id)->update(['status' => 1]);
        return redirect()->route('home');
    }
    /**
     * Affiche la page d'une catégorie spécifique
     *
     * @param string $category Le nom de la catégorie
     * @return \Illuminate\View\View
     */
    public function category($category)
    {
        // Recherche dynamique de la catégorie en BDD
        $categoryModel = \App\Models\Category::where('slug', $category)->first();
        if (!$categoryModel) {
            abort(404, 'Catégorie non trouvée');
        }

        // Récupération des catégories avec le nombre d'articles
        $categories = \App\Models\Category::withCount('posts')->get();

        // Récupération des articles depuis la base avec relations
        $posts = Post::with(['user', 'category'])
            ->latest()
            ->where('category_id', $categoryModel->id)
            ->take(5)
            ->get();

        $allPost = Post::with(['user', 'category'])->get();

        return view('main.pages.categoryPage.allCategories', [
            'categoryTitle' => $categoryModel->name
        ], compact('posts', 'categories', 'allPost'));
    }

    /**
     * Charge plus d'articles pour une catégorie donnée (pagination AJAX)
     */
    public function loadMoreArticles(Request $request)
    {
        $page = $request->input('page', 1);
        $articles = \App\Models\Post::with(['user', 'category', 'bookmarks'])
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
