<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfNotAuthenticatedHome;
use App\Http\Requests\PostFilterRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\PostHelpers;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use PostHelpers;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFilterRequest $request)
    {
        // Création d'une nouvelle instance de Post
        $post = new Post();
        // Gestion de la nouvelle catégorie
        if ($request->filled('compose__new-category')) {
            $category = Category::firstOrCreate([
                'name' => $request->input('compose__new-category'),
                'slug' => Str::slug($request->input('compose__new-category')),
            ]);
            $post->category_id = $category->id;
        } else {
            $post->category_id = $request->input('compose__category');
        }
        // Récupère le titre depuis le formulaire
        $post->title = $request->input('compose__title');
        // Si la case "Slug automatique" est cochée, génère le slug à partir du titre, sinon prend la valeur saisie
        $post->slug = $request->input('compose__custom-slug') === 'on' ? Str::slug($request->input('compose__title')) : $request->input('compose__slug');
        // Récupère le contenu de l'article
        $post->content = $request->input('compose__content');
        // Si la case "Temps de lecture automatique" est cochée, calcule le temps de lecture, sinon prend la valeur saisie
        $post->reading_time = $request->input('compose__custome-reading-time') === 'on' ? self::calculateReadingTime($request->input('compose__content')) : $request->input('compose__reading-time');
        // Associe l'article à l'utilisateur connecté
        $post->user_id = Auth::id();
        // Stocke l'image de couverture si elle est présente
        $post->cover_image = $request->file('compose__cover-image') ? 'storage/' .  $request->file('compose__cover-image')->store('posts', 'public') : null;
        // date de publication de l'article
        $post->published_at = now();
        // date de création de l'article
        $post->created_at = now();
        // date de mise à jour de l'article
        $post->updated_at = now();
        // Sauvegarde l'article en base de données
        $post->save();
        // Redirige vers la page d'accueil avec un message de succès
        return redirect()->route('home')
            ->with('type', 'success')
            ->with('content', 'Votre article a été publié avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($username, $id)
    {
        $user = User::where('username', $username)->firstOrFail();
        $post = Post::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $categories = Category::all();
        return view('main.master-main', compact('post', 'categories', 'user'));
    }

    /**
     * Show the form for editing the specified resource by username and slug.
     */
    public function editBySlug($username, $slug)
    {

        $user = User::where('username', $username)->firstOrFail();
        $post = Post::where('slug', $slug)->where('user_id', $user->id)->firstOrFail();
        $categories = Category::all();
        return view('main.master-main', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFilterRequest $request, Post $post)
    {
        $data = $request->validated();

        // Upload image
        if ($path = $this->handleImageUpload($request, $post)) {
            $data['cover_image'] = $path;
        }

        // Nouvelle catégorie ?
        if ($request->filled('compose__new-category')) {
            $category = Category::firstOrCreate([
                'name' => trim($request->input('compose__new-category'))
            ]);
            $post->category_id = $category->id;
        } elseif (isset($data['compose__category'])) {
            $post->category_id = $data['compose__category'];
        }

        // Slug & Reading time
        $slug = (isset($data['compose__custom-slug']) && $data['compose__custom-slug'] === 'on')
            ? Str::slug($data['compose__title'])
            : Str::slug($data['compose__slug'] ?? $data['compose__title']); // fallback au titre si slug absent

        $readingTime = (isset($data['compose__custome-reading-time']) && $data['compose__custom-reading-time'] === 'on')
            ? self::calculateReadingTime($data['compose__content'])
            : ($data['compose__reading-time'] ?? self::calculateReadingTime($data['compose__content']));


        // Mise à jour des champs
        $post->title        = $data['compose__title'];
        $post->slug         = $slug;
        $post->content      = $data['compose__content'];
        $post->reading_time = $readingTime;
        $post->cover_image  = 'storage/' . $data['cover_image'] ?? 'storage/' . $post->cover_image;
        $post->updated_at   = now();

        $post->save();


        return redirect()->route('article.show', [
            'username' => $post->user->username,
            'slug'     => $post->slug
        ])
            ->with('type', 'success')
            ->with('content', 'Votre article a été modifié avec succès.');
    }

    private function handleImageUpload(Request $request, Post $post): ?string
    {
        if ($request->hasFile('compose__cover-image') && $request->file('compose__cover-image')->isValid()) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            return $request->file('compose__cover-image')->store('posts', 'public');
        }
        return null;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Récupération de l'article
        $article = Post::findOrFail($id);

        // Suppression de l'article
        $article->delete();

        // Empêcher le retour arrière sur la page supprimée
        return redirect()->route('home', [
            'type' => 'success',
            'content' => 'Article supprimé avec succès.'
        ])->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }
}
