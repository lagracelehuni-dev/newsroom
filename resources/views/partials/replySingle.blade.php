<div class="comment comment--reply" data-comment-id="{{ $reply->id }}">
    <div class="comment__avatar comment__avatar--reply">
        <div class="comment__avatar-img">
            <img src="{{ $reply->user->avatar ? asset('/storage/' . $reply->user->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
        </div>
    </div>

    <div class="comment__content">
        {{-- Header --}}
        <div class="comment__content-header">
            <div class="comment__content-infos">
                <a href="{{ route('profil', ['username' => $reply->user && $reply->user->username ? $reply->user->username : 'visiteur']) }}" class="comment__content-name">
                    {{ $reply->user && $reply->user->username ? '@' . $reply->user->username : 'Utilisateur inconnu' }}
            </a>
            <i class="ri ri-circle-fill"></i>
            <p class="comment__content-date">
                {{ $reply->created_at->diffForHumans() }}
            </p>
        </div>
        @if (Auth::user() && Auth::user()->id === $reply->user_id)
        <button class="comment__content-more content-trigger--more"><i class="ri ri-more-2-fill"></i></button>
        <div class="comment__content-pannel">
            <ul class="content-pannel__box">
                <li><a href="#" class="content-pannel__link content-pannel--modifier" ><i class="ri ri-edit-2-line"></i> Modifier la réponse</a></li>
                <li><a href="#" class="content-pannel__link content-pannel--delete" ><i class="ri ri-delete-bin-6-line"></i> Supprimer la réponse</a></li>
            </ul>
        </div>
        @endif
    </div>
    {{-- Body --}}
    <div class="comment__content-body">
        <div class="comment__content-text">
            <p class="text__paragraph">
                {{ $reply->content }}
            </p>
            @if ($reply->image)
            <div class="comment__content-img">
                <img src="{{ asset('storage/' . $reply->image) }}" alt="Image de la réponse">
            </div>
            @endif
            <button class="comment__content-text__btn btn-text--seemore">Voir plus</button>
            <button class="comment__content-text__btn btn-text--showless">Voir moins</button>
            @if($reply->replies && $reply->replies->count() > 0)
            <a href="{{ route('article.reply', ['username' => $post->user->username, 'slug' => $post->slug, 'id' => encrypt($reply->id)]) }}" class="comment__content-responses">
                Voir {{ $reply->replies->count() }} autre{{ $reply->replies->count() > 1 ? 's' : '' }} réponse{{ $reply->replies->count() > 1 ? 's' : '' }}
            </a>
            @endif
        </div>
    </div>
    {{-- Footer --}}
    <div class="comment__content-footer">
        <div class="comment__content-actions">
            <button class="btn__content-actions btn--like tooltip tooltip--top-right {{ Auth::check() ? 'action-react' : 'popup-trigger' }}" data-id="{{ $reply->id }}" data-type="reply" data-title="Liker">
                <i class="ri ri-heart-{{ $reply->likes->contains('user_id', Auth::id()) ? 'fill' : 'line' }} ri-lg"></i>
                <p>{{ $reply->likes_count ?? "" }}</p>
            </button>
            <button class="trigger-reply btn__content-actions btn--reply"><i class="ri ri-reply-all-fill ri-lg"></i> <p>Répondre</p></button>
        </div>
        @if($comment->replies && $comment->replies->count() > 0)
            <button type="button" class="comment__content-responses">
                <p class="text__show-responses">Voir {{ $comment->replies->count() }} autre{{ $comment->replies->count() > 1 ? 's' : '' }} réponse{{ $comment->replies->count() > 1 ? 's' : '' }}</p>
                <p class="text__hide-responses">Masquer les réponses</p>
                <i class="ri-arrow-down-s-line"></i>
            </button>
        @endif
    </div>
</div>
