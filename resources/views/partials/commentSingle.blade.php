@php $actionReact = Auth::check() ? 'action-react' : 'popup-trigger'; @endphp
<div class="comment" data-comment-id="{{ $comment->id }}">
    <div class="comment__avatar">
        <div class="comment__avatar-img">
            <img src="{{ $comment->user->avatar ? asset($comment->user->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
        </div>
    </div>

    <div class="comment__content">
        {{-- Header --}}
        <div class="comment__content-header">
            <div class="comment__content-infos">
                <a {{ Auth::check() ? ("href=" . route('profil', ['username' => $comment->user->username])) : "" }} class="{{ $actionReact }} comment__content-name">
                    {{ "@" . $comment->user->username ?? 'Utilisateur inconnu' }}
                </a>
                <i class="ri ri-circle-fill"></i>
                <p class="comment__content-date">
                    {{ isset($comment->created_at) ? str_replace(['il y a ', 'il y a'], '', $comment->created_at->diffForHumans()) : '' }}
                </p>
            </div>
            @if (Auth::user() && Auth::user()->id === $comment->user_id)
            <button class="comment__content-more content-trigger--more"><i class="ri ri-more-2-fill"></i></button>
            <div class="comment__content-pannel">
                <ul class="content-pannel__box">
                    <li><button type="button" class="content-pannel__link content-pannel--modifier"><i class="ri ri-edit-2-line"></i> Modifier le commentaire</button></li>
                    <li><button type="button" class="content-pannel__link content-pannel--delete" ><i class="ri ri-delete-bin-6-line"></i> Supprimer le commentaire</button></li>
                </ul>
            </div>
            @endif
        </div>
        {{-- Body --}}
        <div class="comment__content-body">
            @if ($comment->parent_id && $comment->parent && $comment->parent->user)
            <div class="comment__content-inresponseto">
                <p>En réponse à <a href="{{ route('profil', ['username' => $comment->parent->user->username]) }}" class="inresponseto-link">{{ '@' . $comment->parent->user->username }}</a></p>
            </div>
            @endif
            <div class="comment__content-text">
                <p class="text__paragraph">
                    {{ $comment->content }}
                </p>
                <button class="comment__content-text__btn btn-text--seemore">Voir plus</button>
                <button class="comment__content-text__btn btn-text--showless">Voir moins</button>
                @if ($comment->image)
                <div class="lightbox-trigger comment__content-img">
                    <img src="{{ asset($comment->image) }}" alt="Image de la réponse">
                </div>
                @endif

            </div>
        </div>
        {{-- Footer --}}
        <div class="comment__content-footer">
            <div class="comment__content-actions">
                <button class="{{ $actionReact }} btn__content-actions like-btn btn--like tooltip tooltip--top-right" data-id="{{ $comment->id }}" data-type="comment" data-title="Liker">
                    <i class="ri ri-heart-{{ $comment->likes->contains('user_id', Auth::id()) ? 'fill' : 'line' }} ri-lg"></i>
                    <p>{{ Auth::check() && $comment->likes_count !== 0 ? $comment->likes_count : "" }}</p>
                </button>
                <button class="{{ $actionReact }} trigger-reply btn__content-actions btn--reply" data-comment-username="{{ $comment->user->username }}"><i class="ri ri-reply-all-fill ri-lg"></i> <p>Répondre</p></button>
            </div>
            @if($comment->replies && $comment->replies->count() > 0)
                <button type="button" class="comment__content-responses">
                    <p class="text__show-responses">Voir {{ $comment->replies->count() }} autre{{ $comment->replies->count() > 1 ? 's' : '' }} réponse{{ $comment->replies->count() > 1 ? 's' : '' }}</p>
                    <p class="text__hide-responses">Masquer les réponses</p>
                    <i class="ri-arrow-down-s-line"></i>
                </button>
            @endif
        </div>
        {{-- les réponses d'un commentaire --}}
        <div class="comment__replies-container">
            @if($comment->replies && $comment->replies->count() > 0)
                <div class="comment__replies">
                    @foreach($comment->replies as $reply)
                        @include('partials.commentSingle', ['comment' => $reply])
                    @endforeach
                </div>
                {{-- Bouton show/hide responses --}}
                <div class="btn-show__stack">
                    <button class="comment__content-show btn__show-more">Afficher plus</button>
                    <button class="comment__content-show btn__show-less">Afficher moins</button>
                </div>
            @endif
        </div>
    </div>

</div>
