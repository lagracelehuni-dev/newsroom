@extends('main.master-main')

@section('main')
<div class="section section--home section--scroll">
    <div class="section__header">
        <button type="button" class="section__back trigger-back">
            <i class="ri ri-arrow-left-line"></i>
        </button>
        <p class="section__category-title">Bookmarks</p>
    </div>

    <x-navbar-top>Bookmarks</x-navbar-top>

    <div class="bookmarks__body">
        <div class="bookmarked-posts">
            @forelse($bookmarkedPosts as $post)
                @php
                    $user = $post->user ?? null;
                    $category = $post->category ?? null;
                    $authUser = Auth::user();
                    $isBookmarked = $authUser && $authUser->bookmarks->contains('id', $post->id);
                    $username = $user?->username ?? 'inconnu';
                    $slug = $post->slug ?? 'non-disponible';
                @endphp

                <div class="post">
                    <div class="post__content">
                        {{-- Header --}}
                        <div class="post__header">
                            <div class="post__author-avatar">
                                <img src="{{ $user && $user->avatar ? asset($user->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
                            </div>
                            <div class="post__author-info">
                                <a
                                    href="{{ route('profil', ['username' => $username]) }}"
                                    class="post__author-name">
                                    {{ $user ? $user->first_name . ' ' . $user->last_name : 'Auteur inconnu' }}
                                </a>
                                <i class="ri ri-circle-fill"></i>
                                <p class="post__date">
                                    {{ $post->published_at ? preg_replace('/^il y a\s*/', '', $post->published_at->diffForHumans()) : 'À l\'instant' }}
                                </p>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="post__body">
                            <div class="post__text">
                                <h2 class="post__title">"{{ $post->title ?? 'Article introuvable' }}"</h2>
                                <p class="post__description">
                                    {{ Str::limit($post->content ?? 'Contenu non disponible', 300) }}
                                </p>

                                <a href="{{ route('article.show', ['username' => $username, 'slug' => $slug]) }}" class="post__read-more">
                                    Lire plus
                                </a>
                            </div>

                            {{-- Image de couverture --}}
                            @if($post->cover_image)
                                <div class="post__thumbnail-container">
                                    <div
                                        class="post__thumbnail lightbox-trigger"
                                        style="background-image: url('{{ asset($post->cover_image) }}');"
                                        data-img="{{ asset($post->cover_image) }}"
                                        aria-label="Voir l'image en taille réelle">
                                        <div class="post__thumbnail-overlay"></div>
                                    </div>
                                </div>
                            @endif

                            {{-- Meta --}}
                            <div class="post__meta">
                                @if($category && $category->slug)
                                    <a href="{{ route('category', ['category' => $category->slug]) }}" class="post__category">
                                        {{ $category->name ?? 'Sans catégorie' }}
                                    </a>
                                @else
                                    <span class="post__category">{{ $category->name ?? 'Sans catégorie' }}</span>
                                @endif

                                <i class="ri ri-circle-fill ico"></i>
                                <p class="post__reading-time">
                                    {{ $post->reading_time ?? 1 }} min. de lecture
                                </p>

                                <i class="ri ri-circle-fill ico"></i>
                                <button class="post__signet bookmark-toggle tooltip tooltip--bottom-left" data-title="{{ $isBookmarked ? 'Retirer des enregistrements' : 'Ajouter aux enregistrements' }}" data-id="{{ $post->id }}">
                                    <i class="ri-bookmark-{{ $isBookmarked ? 'fill' : 'line' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="notification__empty">Vous n'avez enregistré aucun article.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
@section('sidebar')
    <div class="sidebar__content">
        @include('partials.sidebarContent')
    </div>
@endsection
