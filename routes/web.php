<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArticleDetailsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EditProfilController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\IdentifyAccountController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function() {
    return view('welcome')->with('redirectTo', route('home'));
});
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::post('/home{id}', [HomeController::class, 'closeCongrats'])->name('closeCongrats');
// Routes pour les catégories
Route::controller(HomeController::class)->group(function () {
    // Route dynamique pour toutes les catégories (plus de where fixe)
    Route::get('/home/category/{category}', 'category')->name('category');
});

Route::prefix('{username}/article')->name('article.')->controller(ArticleDetailsController::class)->group(function () {
    Route::get('/{slug}', 'show')->name('show');
});

// Route::get('/article/reply/{id}', [ArticleDetailsController::class, 'reply'])->name('article.reply');

Route::post('/mark-visited', function() {
    session()->forget('show_welcome');
    return response()->noContent();
})->middleware('web');

Route::get('/json-data', function (\Illuminate\Http\Request $request) {
    $query = strtolower($request->query('query', ''));

    // Recherche des articles
    $articles = [];
    if ($query) {
        $articles = Post::with(['user', 'category'])
            ->whereRaw('LOWER(title) LIKE ?', ["%$query%"])
            ->orWhereHas('category', function($q) use ($query) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%$query%"])
                    ->orWhereRaw('LOWER(slug) LIKE ?', ["%$query%"]);
            })
            ->limit(10)
            ->get()
            ->map(function($article) {
                $username = $article->user ? $article->user->username : 'user';
                $categoryName = $article->category ? $article->category->name : '';
                $categorySlug = $article->category ? $article->category->slug : '';
                return [
                    'title' => $article->title,
                    'category' => $categoryName,
                    'category_slug' => $categorySlug,
                    'url' => route('article.show', ['username' => $article->user->username ?? '*', 'slug' => $article->slug]),
                ];
            });
    }

    // Recherche des auteurs
    $authors = [];
    if (Auth::check() && $query) {
        $authors = User::whereRaw('LOWER(first_name) LIKE ?', ["%$query%"])
            ->orWhereRaw('LOWER(last_name) LIKE ?', ["%$query%"])
            ->orWhereRaw('LOWER(username) LIKE ?', ["%$query%"])
            ->limit(10)
            ->get()
            ->map(function($author) {
                return [
                    'name' => trim($author->first_name . ' ' . $author->last_name),
                    'username' => $author->username,
                    'avatar' => $author->avatar ?? null,
                    'url' => route('profil', ['username' => $author->username ?? '*'])
                ];
            });
    }

    return response()->json([
        'articles' => $articles,
        'authors' => $authors,
    ]);
});

Route::get('/search', [MasterController::class, 'search'])->name('search');
Route::middleware('NotAuth')->controller(MasterController::class)->group(function () {
    Route::get('/profil/{username}',  'profil')->name('profil');
    Route::get('/compose',  'compose')->name('compose');
});

// Edit profil
Route::middleware('NotAuth')->controller(EditProfilController::class)->group(function () {
    Route::get('/profil/edit/{username}', 'editProfil')->name('profil.edit');
    Route::put('/profil/update', 'updateProfil')->name('profil.update');

});

Route::name('auth')->controller(AuthController::class)->group(function () {
    Route::get('/login','getLogin')->name('.login')->middleware('guest');
    Route::post('/login','login');
    Route::get('/signup','getSignup')->name('.signup')->middleware('guest');
    Route::post('/signup','signup');
    Route::delete('/logout','logout')->name('.logout')->middleware('NotAuth');
});

// Gestion des commentaires et réponses
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/load-more', [CommentController::class, 'loadMore'])->name('comments.loadMore');
Route::post('/comments/{id}/update', [CommentController::class, 'update'])->name('comments.update');
Route::post('/comments/{id}/delete', [CommentController::class, 'delete'])->name('comments.delete');

// Route pour la création d'un post
Route::middleware('NotAuth')->controller(PostController::class)->name('posts')->group(function () {
    Route::post('/posts', 'store')->name('.store');
    Route::get('/posts/{id}/delete', 'destroy')->name('.destroy');
    Route::get('{username}/article/{slug}/edit', 'editBySlug')->name('.edit');
    Route::put('/article/{post}/update', 'update')->name('.update');
});


Route::post('/like', [LikeController::class, 'toggle'])->name('like')->middleware('auth');
// Route pour le chargement progressif (load more) des articles
Route::get('/articles/load-more', [HomeController::class, 'loadMoreArticles'])->name('articles.loadMore');
// Route pour le chargement progressif (load more) des articles
Route::get('/articles/load-more/{username}', [MasterController::class, 'loadMoreArticles'])->name('articles.loadMore');

Route::middleware('NotAuth')->get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::middleware('NotAuth')->post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::middleware('NotAuth')->post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::middleware('NotAuth')->delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

// web.php
Route::middleware(['NotAuth'])->group(function () {
    Route::post('/bookmarks/{post}', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
});

// Étape 1 : Affichage & recherche du compte
Route::get('/forgot-password/identify', [IdentifyAccountController::class, 'showForm'])->name('password.identify');
Route::post('/forgot-password/search', [IdentifyAccountController::class, 'search'])->name('password.search-account');

// Étape 2 : Envoi du code (protégé)
Route::post('/forgot-password/send-code',
    [ForgotPasswordController::class, 'sendResetCodeAfterIdentification']
)->middleware(['identified', 'throttle.reset'])->name('password.send-code');

// Étape 3 : Formulaire code + nouveau mot de passe
Route::get('/verify-reset-code', fn () => view('auth.password.verify-code'))
    ->name('password.verifycode.form');

// Étape 4 : Soumission du nouveau mot de passe
Route::post('/verify-reset-code', [ForgotPasswordController::class, 'reset'])->name('password.verifycode');

// Pour utilisateurs connectés
Route::middleware('NotAuth')->group(function () {
    Route::get('/password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'updatePassword'])->name('password.update.self');
    // Afficher le formulaire pour demander un code de réinitialisation
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
});

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');


Route::get('/account/delete/confirm', [AccountController::class, 'confirmDeletionIntent'])
    ->middleware(['auth'])
    ->name('account.delete.confirm');

Route::get('/account/delete', [AccountController::class, 'showDeleteForm'])->middleware(['auth', 'NotAuth' ,'can.delete.account'])->name('account.delete');
Route::middleware('NotAuth')->group(function () {
    Route::delete('/account/delete', [AccountController::class, 'destroy'])->name('account.destroy');
});


?>




