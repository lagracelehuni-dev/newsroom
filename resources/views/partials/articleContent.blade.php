@php $actionReact = Auth::check() ? 'action-react' : 'popup-trigger'; @endphp
<div class="article__header">
    <div class="article__author">
        <div class="article__author-avatar">
            <img src="{{ $post->user->avatar ? asset($post->user->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
        </div>
        <div class="article__author-infos">
            <a {{ Auth::check() ? ("href=" . route('profil', ['username' => $post->user->username ?? 'visiteur'])) : "" }} class="{{ $actionReact }} article__author-name">{{ $post->user->id ? $post->user->first_name . ' '. $post->user->last_name :'Auteur inconnu' }}</a>
            <p class="article__author-username">{{ '@' . ($post->user->username ?? 'inconnu') }}</p>
        </div>
    </div>

    <div class="article__viewprofile">
        @if (Auth::user() && Auth::user()->id === $post->user_id)
        <button class="article__viewprofile-more viewprofile-trigger--more"><i class="ri ri-more-2-fill"></i></button>
        <div class="article__viewprofile-pannel">
            <ul class="content-pannel__box">
                <li><a href="{{ route('posts.edit', ['username' => $post->user->username, 'slug' => $post->slug]) }}" class="content-pannel__link content-pannel--modifier2"><i class="ri ri-edit-2-line"></i> Modifier l'article</a></li>
                <li><a href="#" class="content-pannel__link content-pannel--delete" data-article-id="{{ $post->id }}"><i class="ri ri-delete-bin-6-line"></i> Supprimer l'article</a></li>
            </ul>
        </div>
        @endif
    </div>
</div>

<div class="article__body">
    <!-- Titre et contenu -->
    <div class="article__text">
        <h2 class="article__title">"{{ $post->title }}"</h2>
        <p class="article__description">
            {!! nl2br(e($post->content)) !!}
        </p>
    </div>

    @if ($post->cover_image)
    <div class="article__thumbnail">
        <img src="{{ asset($post->cover_image) }}" alt="L'image de l'article">
    </div>
    @endif
</div>

<div class="article__footer">
    <div class="article__meta">
        <p>{{ optional($post->published_at)->format('H:i') ?? '' }}</p>
        <i class="ri ri-circle-fill"></i>
        <p>{{ optional($post->published_at)->format('d M Y') ?? '' }}</p>
        <i class="ri ri-circle-fill"></i>
        <p class="num-readings"><span>{{ $post->views_count ?? 0 }}</span> lectures</p>
    </div>

    <div class="article__reactions">
        <div class="article__reaction--first">
            <!-- Bouton like -->
            <button class="{{ $actionReact }} like-btn post__react post--like tooltip tooltip--bottom-left" data-id="{{ $post->id }}" data-type="post" data-title="Liker">
                <i class="ri ri-heart-{{ Auth::check() && $post->likes->contains('user_id', Auth::user()->id) ? 'fill' : 'line' }} ri-lg"></i>
                <p>{{ $post->likes_count !== 0 ? $post->likes_count : "" }}</p>
            </button>
            <!-- Bouton commentaire -->
            <button class="post__react post--comment tooltip tooltip--bottom-left" data-title="Commentaires"><i class="ri ri-chat-1-line ri-lg"></i>
                <p>{{ $post->comments_count !== 0 ? $post->comments_count : "" }}</p>
            </button>
            <!-- Bouton copy link -->
            @php
                $articleUrl = route('article.show', ['username' => $post->user->username, 'slug' => $post->slug]);
            @endphp

            <button
                class="post__react post--share tooltip tooltip--bottom-left btn-copy-link"
                data-url="{{ $articleUrl }}"
                data-title="Copier le lien">
                <i class="ri ri-links-line ri-lg"></i>
            </button>
        </div>
        <div class="article__reaction--second">
            <!-- Bouton sauvegarde -->
            <button class="post__react post--saved bookmark-toggle" data-id="{{ $post->id }}">
                <i class="ri-bookmark-{{ Auth::user()?->bookmarks->contains($post->id) ? 'fill' : 'line' }}"></i>
            </button>

        </div>
    </div>
</div>

