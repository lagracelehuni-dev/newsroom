@extends('master-pass')

@section('mainPass')
<div class="forgot-password-page">
    <div class="forgot-password-card">
        <h2 class="forgot-password-title">Mot de passe oublié</h2>
        <p class="forgot-password-subtitle">
            Entrez l'adresse e-mail associée à votre compte. <br>
            Nous vous enverrons un code de réinitialisation.
        </p>

        @if (session('status'))
            <div class="forgot-password-alert success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="forgot-password-alert danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.send-code') }}" class="forgot-password-form">
            @csrf

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="input"
                    placeholder="exemple@domaine.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary full-width">
                Envoyer le code
            </button>
        </form>

        <div class="forgot-password-footer">
            <a href="{{ route('auth.login') }}" class="forgot-password-link">Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection
