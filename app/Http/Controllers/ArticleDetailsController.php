<?php

namespace App\Http\Controllers;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class ArticleDetailsController extends Controller
{
    //
    public function show($username, $slug)
    {
        $username = Auth::user() ? Auth::user()->username : "lagracelehuni";

        // Récupérer l'article via le slug
        $post = Post::where('slug', $slug)->firstOrFail();

        $likes = Like::all();

        // Récupérer tous les commentaires d’un post avec les réponses
        $comments = Comment::with(['user', 'replies.user', 'likes'])
            ->where('post_id', $post->id)
            ->whereNull('parent_id') // <= on ne prend que les commentaires principaux
            ->latest()
            ->paginate(15); // Limite à 15 commentaires pour la page initiale

        // Récupérer tous les commentaires d’un post avec les réponses
        $comment_count = Comment::with(['user', 'replies.user'])->where('post_id', $post->id)->count();


        $categories = \App\Models\Category::withCount('posts')->get();
        $allPost = Post::with(['user', 'category'])
            ->orderBy('views_count', 'desc') // Trier par le nombre de vues
            ->latest()
            ->take(30)
            ->get();

        // Vérifier si l'article a déjà été consulté dans la session
        $article = Post::where('slug', $slug)->firstOrFail();

        // Utiliser une clé de session unique pour chaque article
        $sessionKey = 'article_viewed_' . $article->id;

        // Si l'article n'a pas été consulté, incrémenter le compteur de vues
        if (!session()->has($sessionKey)) {
            $article->increment('views_count');
            session()->put($sessionKey, true);
        }


        return view('main.master-main', compact('post', 'comments', 'categories', 'allPost', 'username', 'article', 'likes', 'comment_count'));
    }

    public function reply($username, $slug, $id)
    {
        $username = Auth::user() ? Auth::user()->username : "lagracelehuni";

        // Récupérer l'article via le slug
        $post = Post::where('slug', $slug)->firstOrFail();
        $likes = Like::all();

        // Décrypter l'id du commentaire
        $commentId = decrypt($id);
        $comment = Comment::with(['user', 'replies.user', 'likes'])->findOrFail($commentId);

        $categories = \App\Models\Category::withCount('posts')->get();
        $allPost = Post::with(['user', 'category'])
            ->latest()
            ->take(30)
            ->get();

        return view('main.master-main', compact('post', 'comment', 'categories', 'allPost', 'username', 'likes'));
    }
}
