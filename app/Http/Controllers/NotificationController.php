<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Affiche la liste paginée des notifications de l'utilisateur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Récupère toutes les notifications de l'utilisateur, les plus récentes en premier,
        // avec pagination à 20 notifications par page
        $notifications = $user->notifications()->latest()->paginate(20);

        $allPost = Post::with(['user', 'category'])->get();

        // Récupération des catégories avec le nombre d'articles
        $categories = \App\Models\Category::withCount('posts')->get();

        // Retourne la vue 'notifications.index' en passant les notifications récupérées
        return view('main.pages.notifications', compact('notifications', 'allPost', 'categories'));
    }

    /**
     * Marque une notification spécifique comme lue.
     *
     * @param string $id L'identifiant UUID de la notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Recherche la notification correspondante de l'utilisateur connecté
        $notification = $user->notifications()->findOrFail($id);

        // Marque la notification comme lue en enregistrant la date de lecture
        $notification->markAsRead();

        // Redirige l'utilisateur vers la page précédente
        return back();
    }

    /**
     * Marque toutes les notifications non lues de l'utilisateur comme lues.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Récupère toutes les notifications non lues de l'utilisateur et les marque comme lues
        $user->unreadNotifications->markAsRead();

        // Redirige l'utilisateur vers la page précédente
        return back();
    }

    /**
     * Supprime une notification spécifique.
     *
     * @param string $id UUID de la notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification supprimée.');
    }

}
