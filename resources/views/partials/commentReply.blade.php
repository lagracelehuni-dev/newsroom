<form class="comment-reply" method="POST" action="{{ route('comments.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <input type="hidden" name="parent_id" value="{{ $parent_id ?? '' }}"> <!-- parent_id forcé si fourni -->
    <div class="comment-reply__header">
        <div class="comment-reply__header-avatar">
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Photo de profil">
        </div>
        <div class="comment-reply__header-replyto">
            {{-- Répondre à l'auteur du commentaire --}}
            <p class="p__replyto">Répondre à <span>{{ $parent_id ?? ($comment->user->username ?? 'utilisateur') }}</span></p>
        </div>
    </div>
    <div class="comment-reply__body">
        <textarea name="comment" class="comment-reply__textarea" placeholder="Votre réponse..."></textarea>
    </div>
    <div class="comment-reply__footer">
        <!-- Importer une photo (optionnelle) -->
        {{-- <x-image-import
            :extraClass="$extraClass"
            :inputClass="$inputClass"
            :previewClass="$previewClass"
            :btnClass="$btnClass"
            :btnClose="$btnClose"
            :name="$name"
        /> --}}
        <button type="submit" class="comment-reply__btn comment-reply__btn--send">Répondre</button>
    </div>
    <div class="comment-reply__close"><i class="ri ri-close-fill"></i></div>
</form>
