@php
    $actionReact = Auth::check() ? 'action-react' : 'popup-trigger';
@endphp

<div class="bloc__fixed">
    <div class="bloc__absolute">
        <div class="section section--home section--scroll">
            <div class="section__header">
                <button class="section__back trigger-back"><i class="ri ri-arrow-left-line"></i></button>
                <p class="section__category-title">Article</p>
            </div>
            <x-navbar-top>Article</x-navbar-top>

            <div class="article">
                {{-- Le contenu pricipal de l'article --}}
                @include('partials.articleContent', ['post' => $post, 'likes' => $likes])

                {{-- La liste des articles --}}

                {{-- La barre latérale --}}
                {{-- Les commentaires --}}
                @include('partials.commentSection', ['comments' => $comments, 'likes' => $likes])

                {{-- Le box de commentaire --}}
                @include('partials.commentBox', ['userId' => Auth::id(), 'comments' => $comments])
            </div>

        </div>
    </div>
</div>
