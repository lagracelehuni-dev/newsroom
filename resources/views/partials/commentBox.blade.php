@auth
    @php
        $extraClass="comment__import";
        $inputClass="comment__import-input";
        $previewClass="comment__import-img";
        $btnClass="comment-reply__btn comment-reply__btn--image tooltip tooltip--top-left-5";
        $btnClose="comment__import-close";
        $name="import__photo";
    @endphp
<!-- Barre de réponse -->
<form class="comment-reply" method="POST" action="{{ route('comments.store') }}" enctype="multipart/form-data">
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
        <!-- Importer une photo (optionnelle) -->
        <x-image-import
            extraClass="comment__import"
            inputClass="comment__import-input"
            previewClass="comment__import-img"
            btnClass="comment-reply__btn comment-reply__btn--image tooltip tooltip--top-left-5"
            btnClose="comment__import-close"
            name="import__photo"
        />
        <button type="submit" class="comment-reply__btn comment-reply__btn--send">Répondre</button>
    </div>
    <div class="comment-reply__close"><i class="ri ri-close-fill"></i></div>
</form>


<!-- Barre de commentaire -->
<form class="comment-box" method="POST" action="{{ route('comments.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <div class="comment-box__container">
        <div class="comment-box__avatar">
            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
        </div>
        <textarea name="comment" class="comment-box__textarea" placeholder="{{ $placeholder ?? 'Laissez un commentaire...' }}"></textarea>
        <div class="comment-box__actions">
            <x-image-import
                extraClass="comment__import"
                inputClass="comment__import-input"
                previewClass="comment__import-img"
                btnClass="comment-box__btn comment-box__btn--image tooltip tooltip--top-right"
                btnClose="comment__import-close"
                name="import__photo"
            />
            <button type="submit" class="comment-box__btn comment-box__btn--send tooltip tooltip--top-right" data-title="Commenter"><i class="fas fa-paper-plane fa-lg"></i></button>
        </div>
    </div>
</form>
@endauth
