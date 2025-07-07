<div class="comment-section">
    @if ($comments->isNotEmpty())
        <div class="comment-list" data-page="1">
            @foreach ($comments as $comment)
                @include('partials.commentSingle', ['comment' => $comment])
            @endforeach
        </div>

        @if ($comments->count() > 15)
        <!-- Bouton pour charger plus de commentaires -->
        <div class="bloc__btn-loadmore">
            <button class="btn-loadmore btn-loadmore--comment">Afficher plus de commentaires <i class="ri ri-arrow-right-s-line"></i></button>
        </div>
        @endif

    @else
        <p class="comment-nothing"> Aucun commentaire pour le moment. <br> Soyez le premier à commenter cet article !</p>
    @endif
</div>
