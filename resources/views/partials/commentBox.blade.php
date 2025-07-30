@auth
<!-- Barre de réponse -->
<form class="comment-reply" method="POST" action="{{ route('comments.store') }}">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <input type="hidden" name="parent_id" value="{{ $parent_id ?? '' }}"> <!-- parent_id forcé si fourni -->
    <div class="comment-reply__header">
        <div class="comment-reply__header-avatar">
            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
        </div>
        <div class="comment-reply__header-replyto">
            <p class="p__replyto">Répondre à <span></span></p>
        </div>
    </div>
    <div class="comment-reply__body">
        <textarea name="comment" class="comment-reply__textarea" placeholder="Votre réponse..."></textarea>
    </div>
    <div class="comment-reply__footer">
        <button type="submit" class="comment-reply__btn comment-reply__btn--send">Répondre</button>
    </div>
    <div class="comment-reply__close"><i class="ri ri-close-fill"></i></div>
</form>


<!-- Barre de commentaire -->
<form class="comment-box" method="POST" action="{{ route('comments.store') }}">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <div class="comment-box__container">
        <div class="comment-box__avatar">
            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
        </div>
        <div class="comment-box__textarea-container">
            <textarea name="comment" class="comment-box__textarea" placeholder="{{ $placeholder ?? 'Laissez un commentaire...' }}"></textarea>
            <div class="comment-box__actions">
                <button type="submit" class="comment-box__btn comment-box__btn--send tooltip tooltip--top-right" data-title="Commenter"><i class="ri ri-send-plane-2-fill"></i></button>
            </div>
        </div>
    </div>
</form>
@endauth
