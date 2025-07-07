@extends('master-pass')

@section('mainPass')
<section class="section section--reset">
    <div class="reset__container">
        <div class="reset__card">
            <h2 class="reset__title">Vérification du code</h2>
            <p class="reset__description">Entrez le code que vous avez reçu par email.</p>

            @if(session('error'))
                <div class="alert alert--danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert--success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('password.verify-code') }}" method="POST" class="reset__form">
                @csrf
                <input type="hidden" name="email" value="{{ old('email', request()->get('email')) }}">

                <div class="form__group">
                    <label for="code" class="form__label">Code de vérification</label>
                    <input type="text" name="code" id="code" class="form__input" placeholder="Ex: 839241" required autofocus>
                </div>

                <button type="submit" class="btn btn--primary">Vérifier le code</button>
            </form>

            <a href="{{ route('password.request') }}" class="reset__link">← Renvoyer un nouveau code</a>
        </div>
    </div>
</section>
@endsection
