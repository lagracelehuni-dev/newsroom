@extends('master-pass')

@section('mainPass')
<div class="container min-w-50 mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-red-600 mb-4">⚠️ Supprimer mon compte</h2>

    <p class="text-gray-700 mb-4">
        Cette action est <strong>irréversible</strong>. Tous vos articles, commentaires et données seront supprimés définitivement. <br>
        Pour confirmer, veuillez entrer votre mot de passe.
    </p>



    <form action="{{ route('account.destroy') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe</label>
            <input
                type="password"
                id="password"
                name="password"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none @error('password') border-red-400 border-2 focus:ring-2 focus:ring-red-400 @enderror"
                placeholder="Entrez votre mot de passe"
                {{-- @if ($errors->has('password')) disabled @endif --}}
            >
        </div>
        @error("password")
            <p class="text-wrap text-red-500 mb-4"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
        @enderror

        <div class="vstack">
            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">
                Supprimer définitivement
            </button>
            <a href="{{ route('home') }}" class="mb-4 w-full mt-[10px] bg-gray-100 text-center text-gray-500 py-2 px-4 rounded-lg hover:bg-gray-100 transition">
                Supprimer définitivement
            </a>
        </div>
    </form>
</div>
@endsection
