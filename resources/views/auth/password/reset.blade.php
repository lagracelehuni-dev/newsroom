@extends('master-pass')

@section('mainPass')
<div class="section section--form password-reset-page">
    <div class="form__wrapper">
        <h1 class="form__title">Changer mon mot de passe</h1>

        @if (session('status'))
            <div class="alert alert--success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert--danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update.self') }}" method="POST">
            @csrf

            <div class="form__group">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" name="current_password" required>
            </div>

            <div class="form__group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" name="new_password" required>
            </div>

            <div class="form__group">
                <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                <input type="password" name="new_password_confirmation" required>
            </div>

            <button type="submit" class="btn btn--primary">Terminer</button>
        </form>

        <p class="form__link">
            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        </p>
    </div>
</div>
@endsection

