<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title_page')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/@favicon__newsroom--v5.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
   <!-- Vite CSS/JS -->
    @vite(['resources/css/app.css', 'resources/css/scss/styles.scss', 'resources/js/app.js'])
</head>
<body>
    {{-- Alert --}}
    @if (session('content'))
        <x-alert :type="session('type')">
            {{ session('content') }}
        </x-alert>
    @endif

    <!--*------------------------------*
        Button fixed
    !*------------------------------*-->
    <a href="{{ route('home') }}" class="btn-fixed__back tooltip tooltip--bottom-left-5" data-title="Retourner à l'accueil">
      <i class="fas fa-arrow-left-long"></i>
    </a>

    <!--*------------------------------*
        Auth
    !*------------------------------*-->
    <main class="relative auth-page">
        <!-- Animations -->
        <div class="absolute container">
            <div class="relative animate">
                <div class="obj-animate animate--1"></div>
                <!-- <div class="auth-page__animate animate--2"></div> -->
                {{-- <div class="obj-animate animate--3"></div> --}}
            </div>
        </div>

        <!-- Background -->
        <div class="bg-overlay"></div>

        <div class="auth-page__content container">
            <!-- Contenue left -->
            <div class="content-body">
                <div class="content-body__bloc">
                        <div class="content-body__logo">
                            <img src="{{ asset('assets/img/@logo__newsroom--v5.png') }}" alt="logo">
                        </div>
                    <div class="content-body__text">
                        <p class="body__text--title">@yield('text--title')</p>
                        <p class="body__text--paragraph">@yield('text--paragraph')</p>
                    </div>
                </div>
                <div class="content-body__img">
                    <img src="{{ asset('assets/img/brand communication-bro.png') }}" alt="">
                </div>
            </div>

            @yield('content')
        </div>
    </main>

    <!-- Script JS concernant les pages d'authentifications -->
    @vite('resources/js/app.js')
</body>
</html>
