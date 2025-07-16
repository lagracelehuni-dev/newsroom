<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;

// Importation des notifications
use App\Notifications\ArticleLiked;
use App\Notifications\CommentLiked;

class LikeController extends Controller
{
    /**
     * Gère le like/unlike sur un article, un commentaire ou une réponse.
     */
    public function toggle(Request $request)
    {
        $user = Auth::user();

        $likeableType = $request->input('type'); // 'post' ou 'comment'
        $likeableId   = $request->input('id');

        // Association entre les types et les modèles
        $models = [
            'post'    => Post::class,
            'comment' => Comment::class,
        ];

        // Si le type n’est pas reconnu, on renvoie une erreur
        if (!isset($models[$likeableType])) {
            return response()->json(['error' => 'Type de contenu inconnu'], 400);
        }

        // Récupération du modèle (Post ou Comment)
        $modelClass = $models[$likeableType];
        $likeable   = $modelClass::findOrFail($likeableId);

        // Vérifie si l'utilisateur a déjà liké
        $existing = $likeable->likes()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'liked' => false,
                'count' => $likeable->likes()->count(),
            ]);
        }
        // Création du like
        $likeable->likes()->create([
            'user_id' => $user->id,
        ]);

        // ✨ Envoi de notification selon le type
        if ($likeableType === 'post' && $likeable->user_id !== $user->id) {
            // Liker un article
            $likeable->user->notify(new ArticleLiked($user, $likeable));
        }

        if ($likeableType === 'comment' && $likeable->user_id !== $user->id) {
            // Liker un commentaire ou une réponse
            $likeable->user->notify(new CommentLiked($user, $likeable));
        }

        return response()->json([
            'liked' => true,
            'count' => $likeable->likes()->count(),
        ]);
    }
}
