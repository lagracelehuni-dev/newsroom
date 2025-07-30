<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\ArticleCommented;
use App\Notifications\CommentReplied;

class CommentController extends Controller
{
    /**
     * Stocke un nouveau commentaire ou une réponse.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. Validation des champs
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // 2. Vérifie si le champ commentaire n'est pas vide après nettoyage
        if (trim($request->input('comment')) === '') {
            return response()->json([
                'success' => false,
                'message' => 'Le champ commentaire ne peut pas être vide.'
            ], 422);
        }

        // 3. Création du commentaire
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->parent_id = $request->input('parent_id') ?: null;
        $comment->content = $request->comment;

        $comment->save();

        // 4. Chargement des relations utiles pour la vue
        $comment->load('user', 'likes');

        // 5. Notifications
        $user = Auth::user();

        if ($comment->parent_id === null) {
            // Notification pour un nouveau commentaire sur l'article
            $post = Post::find($request->post_id);
            if ($post && $post->user_id !== Auth::id()) {
                $post->user->notify(new ArticleCommented($user, $post, $comment));
            }
        } else {
            // Notification pour une réponse à un commentaire
            $parentComment = Comment::find($comment->parent_id);
            $post = Post::find($request->post_id);
            if ($parentComment && $parentComment->user_id !== Auth::id()) {
                $parentComment->user->notify(new CommentReplied($user, $post, $comment, $parentComment));
            }
        }

        // 6. Rendu HTML du nouveau commentaire
        $commentHtml = view('partials.commentSingle', compact('comment'))->render();

        return response()->json([
            'success' => true,
            'comment_html' => $commentHtml,
        ]);
    }

    /**
     * Met à jour un commentaire existant.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // 1. Validation
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // 2. Récupération du commentaire
        $comment = Comment::findOrFail($id);

        // 3. Vérification d'autorisation
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Action non autorisée.'
            ], 403);
        }

        // 4. Mise à jour du contenu
        $comment->content = $request->comment;
        $comment->save();

        // 5. Reload des relations nécessaires
        $comment->load('user', 'likes');

        // 6. Rendu HTML mis à jour
        $commentHtml = view('partials.commentSingle', compact('comment'))->render();

        return response()->json([
            'success' => true,
            'comment_html' => $commentHtml,
        ]);
    }

    /**
     * Supprime un commentaire.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        // Vérification d'autorisation
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Action non autorisée.'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commentaire supprimé avec succès.'
        ]);
    }

    public function loadMore(Request $request)
    {
        // 1. Validation
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'page'    => 'nullable|integer|min:1',
        ]);

        $postId = $request->input('post_id');
        $page   = (int) $request->input('page', 1);
        $limit  = 5; // ← Tu peux modifier ce nombre à tout moment ici
        $offset = ($page - 1) * $limit;

        // 2. Récupération des commentaires principaux avec pagination
        $comments = Comment::where('post_id', $postId)
            ->whereNull('parent_id') // uniquement les commentaires racines
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->with(['user', 'likes', 'replies.user', 'replies.likes']) // relations utiles
            ->get();

        // 3. Vérifie s’il y a des commentaires à afficher
        if ($comments->isEmpty()) {
            return response()->json([
                'html'     => null,
                'hasMore'  => false,
                'nextPage' => $page + 1,
            ]);
        }

        // 4. Génération HTML de tous les commentaires
        $html = '';
        foreach ($comments as $comment) {
            $html .= view('partials.commentSingle', compact('comment'))->render();
        }

        // 5. Calcul du nombre total pour savoir s’il reste des commentaires
        $totalComments = Comment::where('post_id', $postId)
            ->whereNull('parent_id')
            ->count();

        $hasMore = ($offset + $limit) < $totalComments;

        // 6. Réponse pour le JS
        return response()->json([
            'html'     => $html,
            'hasMore'  => $hasMore,
            'nextPage' => $page + 1,
        ]);
    }





}
