@extends('master-pass')

@section('mainPass')
<section class="section section--reset">
    <div class="reset__container">
        <div class="reset__card">
            <h2 class="reset__title">Réinitialisation du mot de passe</h2>
            <p class="reset__description">Entrez l’adresse email liée à votre compte. Nous vous enverrons un code de réinitialisation.</p>

            @if (session('error'))
                <div class="alert alert--danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert--danger">
                    <ul class="alert__list">
                        @foreach ($errors->all() as $error)
                            <li class="alert__item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.send-code') }}" method="POST" class="reset__form">
                @csrf
                <div class="form__group">
                    <label for="email" class="form__label">Adresse email</label>
                    <input type="email" name="email" id="email" class="form__input" placeholder="exemple@email.com" required autofocus>
                </div>

                <button type="submit" class="btn btn--primary">Envoyer le code</button>
            </form>

            <a href="{{ route('auth.login') }}" class="reset__link">← Retour à la connexion</a>
        </div>
    </div>
</section>
@endsection
