@extends('master-pass')

@section('mainPass')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Réinitialiser le mot de passe</h2>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('password.verifycode') }}" class="space-y-5">
            @csrf

            <!-- Email (masqué ou visible selon ton choix) -->
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

            <!-- Code reçu par email -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Code de vérification</label>
                <input id="code" name="code" type="text" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Ex: 483261">
                <!-- Affichage des erreurs -->
                @error('code')
                    <p class="mb-4 text-sm text-red-600"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Nouveau mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input id="password" name="password" type="password" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <!-- Affichage des erreurs -->
                @error('password')
                    <p class="mb-4 text-sm text-red-600"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <!-- Affichage des erreurs -->
                @error('password_confirmation')
                    <p class="mb-4 text-sm text-red-600"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200 font-semibold">
                    Réinitialiser le mot de passe
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">
                Abandonner l'action
            </a>
        </div>
    </div>
</div>
@endsection
