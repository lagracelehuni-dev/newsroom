<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsroom</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/@favicon__newsroom--v5.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <!-- Vite CSS/JS -->
    @vite(['resources/css/app.css', 'resources/css/scss/styles.scss', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @php $actionReact = Auth::check() ? 'action-react' : 'popup-trigger'; @endphp

    @yield('pagesComponents')

    {{-- Popup --}}
    @auth
        @if (Auth::user()->status == 0)
            <x-popup-congrats></x-popup-congrats>
        @endif

        @if (request()->has('content') && request()->has('type'))
            <x-alert :type="request('type')">
                {{ request('content') }}
            </x-alert>
        @elseif (session('content'))
            <x-alert :type="session('type')">
                {{ session('content') }}
            </x-alert>
        @endif

        {{-- Modal de deconnexion --}}
        <div class="bloc__modal bloc--modal-logout">
            <div class="bloc__modal-content">
                <h2 class="bloc__modal-title">Déconnexion</h2>
                <p class="bloc__modal-text">Êtes-vous sûr de vouloir vous déconnecter ?</p>
                <div class="bloc__modal-actions hstack">
                    <button class="btn btn-outlined-secondary trigger-close">Annuler</button>
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        @method("delete")
                        <button class="btn btn-primary">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal de delete account --}}
        <div class="bloc__modal bloc--modal-delete-account">
            <div class="bloc__modal-content">
                <h2 class="bloc__modal-title">Suppression de compte</h2>
                <p class="bloc__modal-text">Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                <div class="bloc__modal-actions hstack">
                    <button class="btn btn-outlined-secondary trigger-close">Annuler</button>
                    <a href="{{ route('account.delete.confirm') }}" class="btn btn-primary">Continuer</a>
                </div>
            </div>
        </div>

        <div class="bloc__confirm-action"></div>
        <div class="bloc__show-msg">
            {{-- <p class="comment-message success">Commentaire envoyé avec succès !</p> --}}
            {{-- <p class="comment-message error">Erreur lors de l'envoi du commentaire.</p> --}}
        </div>
    @endauth

    @guest
        @if (session('show_welcome'))
        <x-popup-welcome></x-popup-welcome>
        @endisset

        <x-popup-alert></x-popup-alert>

    @endguest







    <main class="relative homepage">
        <!-- Animations -->
        {{-- <div class="absolute container">
            <div class="relative animate">
                <div class="obj-animate animate--1"></div>
                <!-- <div class="auth-page__animate animate--2"></div> -->
                <div class="obj-animate animate--3"></div>
            </div>
        </div> --}}

        <!-- Background -->
        <div class="bg-overlay"></div>

        <main class="homepage__main">

            <!-- Sidebar left -->
            @include('partials.sidebar-Left')

            <!-- Main content -->
            @yield('content')

        </main>

        @auth
            <x-navbar-bottom></x-navbar-bottom>
        @endauth

    </main>



    <x-pannel-auth></x-pannel-auth>

    {{-- Lightbox --}}
    <div class="lightbox">
        <div class="lightbox__content">
            {{-- Image qui sera affichée dans la lightbox --}}
            <img class="lightbox__image" src="" alt="Image en taille réelle">

            {{-- Bouton pour fermer la lightbox --}}
            <button class="lightbox__close" aria-label="Fermer la lightbox"><i class="ri ri-close-fill"></i></button>
        </div>
    </div>



    @vite('resources/js/app.js')
</body>
</html>
