@php use Illuminate\Support\Str; @endphp
@php $actionReact = Auth::check() ? 'action-react' : 'popup-trigger'; @endphp

@foreach ($posts as $post)
    @php
        $author = $post->user ?? null;
        $category = $post->category ?? null;
        $isBookmarked = Auth::check() && Auth::user()->bookmarks->contains('id', $post->id);
    @endphp

    <div class="post">
        <div class="post__content">
            {{-- Header --}}
            <div class="post__header">
                <div class="post__author-avatar">
                    <img src="{{ $author && $author->avatar ? asset($author->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
                </div>

                <div class="post__author-info">
                    <a
                        href="{{ Auth::check() && $author ? route('profil', ['username' => $author->username]) : '#' }}"
                        class="{{ $actionReact }} post__author-name"
                    >
                        {{ $author ? ($author->first_name . ' ' . $author->last_name) : 'Auteur inconnu' }}
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

                    <a href="{{ route('article.show', ['username' => $author->username ?? 'inconnu', 'slug' => $post->slug ?? 'non-disponible']) }}" class="post__read-more">Lire plus</a>
                </div>

                {{-- Image de couverture --}}
                @if (!empty($post->cover_image))
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
                    @if ($category && $category->slug)
                        <a href="{{ route('category', ['category' => $category->slug]) }}" class="post__category">{{ $category->name }}</a>
                    @else
                        <span class="post__category">{{ $category->name ?? 'Sans catégorie' }}</span>
                    @endif

                    <i class="ri ri-circle-fill ico"></i>
                    <p class="post__reading-time">{{ $post->reading_time ?? 1 }} min. de lecture</p>

                    @auth
                        <i class="ri ri-circle-fill ico"></i>
                        <button
                            class="post__signet bookmark-toggle tooltip tooltip--bottom-left"
                            data-title="{{ $isBookmarked ? 'Retirer des enregistrements' : 'Ajouter aux enregistrements' }}"
                            data-id="{{ $post->id }}"
                        >
                            <i class="ri-bookmark-{{ $isBookmarked ? 'fill' : 'line' }}"></i>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endforeach
