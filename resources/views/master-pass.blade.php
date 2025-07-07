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

    @auth
        {{-- Affichage de message d'alert --}}
        @if (session('content'))
            <x-alert :type="session('type')">
                {{ session('content') }}
            </x-alert>
        @endif
    @endauth

    <main class="principal">
        @yield('mainPass')
    </main>

    @vite('resources/js/app.js')
</body>
</html>
