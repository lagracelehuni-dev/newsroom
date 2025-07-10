@extends('master-pass')

@section('mainPass')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Mot de passe oublié ?</h2>
        <p class="text-lg text-gray-800 mb-6 text-start">
            Entrez l'adresse e-mail associée à votre compte. <br>
            Nous vous enverrons un code de réinitialisation.
        </p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input id="email" name="email" type="email" autofocus
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 transition duration-200 @error('email') focus:ring-red-500  focus:border-red-500 @enderror "
                       placeholder="ex: vous@example.com">
                <!-- Affichage des erreurs -->
                @error('email')
                    <p class="mb-4 text-sm text-red-600"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200 font-semibold">
                    Envoyer le code de réinitialisation
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
