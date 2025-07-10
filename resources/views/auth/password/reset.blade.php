@extends('master-pass')

@section('mainPass')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Changer votre mot de passe</h2>

        <!-- Formulaire de mise à jour -->
        <form method="POST" action="{{ route('password.update.self') }}" class="space-y-5">
            @csrf

            <!-- Mot de passe actuel -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                <input id="current_password" name="current_password" type="password"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <!-- Affichage des erreurs -->
                @error('current_password')
                    <p class="mb-4 text-sm text-red-600"><i class="ri-error-warning-fill"></i>  {{ $message }}</p>
                @enderror
            </div>

            <!-- Nouveau mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input id="password" name="password" type="password"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <!-- Affichage des erreurs -->
                @error('password')
                    <p class="mb-4 text-sm text-red-600"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
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
                    Mettre à jour
                </button>
            </div>

            <!-- Lien mot de passe oublié -->
            <div class="text-center mt-4">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                    Mot de passe oublié ?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

