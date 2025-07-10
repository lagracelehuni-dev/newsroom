@extends('master-pass')

@section('mainPass')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 space-y-6">

        <h2 class="text-2xl font-bold text-gray-800 text-center">Trouvons votre compte</h2>
        <p class="text-sm text-gray-500 text-center">Entrez l’adresse email associée à votre compte.</p>

        <!-- Formulaire de recherche -->
        <form method="POST" action="{{ route('password.search-account') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input id="email" name="email" type="email" required
                    value="{{ old('email') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    placeholder="ex: utilisateur@exemple.com">
                @error("email")
                    <p class="mb-4 text-sm text-red-600"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200 font-semibold">
                    Rechercher le compte
                </button>
            </div>
        </form>

        <!-- Aperçu du compte si trouvé -->
        @if(session('user_found'))
            <div class="border-t pt-6 mt-4">
                <p class="text-center text-sm text-gray-600 mb-4">Compte trouvé :</p>

                <div class="flex flex-col items-center space-y-2">
                    <img src="{{ session('user_avatar') }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border">
                    <p class="text-lg font-semibold text-gray-800">{{ "@" . session('user_username') }}</p>
                    <p class="text-sm text-gray-500">{{ session('user_email') }}</p>
                </div>

                <form method="POST" action="{{ route('password.send-code') }}" class="mt-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('user_email') }}">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200 font-semibold">
                        Envoyer le code de réinitialisation
                    </button>
                </form>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('auth.login') }}" class="text-sm text-blue-600 hover:underline">Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection
