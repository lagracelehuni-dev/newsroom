@extends('master')

@section('pagesComponents')


{{-- Pages Components (tous les composants de page sont ici, inclus selon l'authentification) --}}
    @if (request()->routeIs('article.show'))
        {{-- Si on est sur une page d'article --}}
        <x-article-details :post="$post" :likes="$likes" :comments="$comments"></x-article-details>
    @endif


    @auth

        @if (request()->routeIs('profil.edit'))
            {{-- Si on est sur la page d'édition du profil --}}
            <x-edit-profil :user="$user"></x-edit-profil>
        @endif
        @if (request()->routeIs('compose'))
            {{-- Si on est sur la page de composition d'article --}}
            <x-compose-page :categories="$categories" />
        @endif
        @if (request()->routeIs('posts.edit') && isset($post) && isset($categories))
            {{-- Si on est sur la page de modification d'article --}}
            <x-compose-update :post="$post" :categories="$categories"></x-compose-update>
        @endif
    @endauth
{{-- End Pages Components --}}

@endsection

@section('content')

<section class="main">
    @yield('main')
</section>

<!-- Sidebar right -->
<section class="sidebar sidebar--right">
    @yield('sidebar')

    <footer class="footer">
        <ul class="footer__content">
            <li><a href="#" class="footer__link">Conditions d'utilisation</a></li>
            <li><a href="#" class="footer__link">Politique de Confidentialité</a></li>
            <li><a href="#" class="footer__link">Politique relative aux cookies</a></li>
            <li class="footer__item" >© 2025 Newsroom. By LaGrace Lehuni.</li>
        </ul>
    </footer>
</section>

@endsection
