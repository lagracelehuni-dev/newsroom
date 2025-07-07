@extends('auth.master-auth')

@section('title_page')
Connexion
@endsection

@section('text--title')
Bienvenue à nouveau !
@endsection

@section('text--paragraph')
Connectez-vous à votre compte pour retrouver
<br>vos articles préférés, intéragir avec la communauté
<br>et partager vos idées.
@endsection

@section('content')
    <!-- Formulaire -->
    <div class="content-form">
        <div class="content-form__bloc">
            <!-- TItre -->
            <div class="bloc-form__title">
                <p class="title__h">Se connecter</p>
                <p class="title__p">Entrez vos données personnelles pour se connecter.</p>
            </div>
            <!-- Formulaire -->
            <form action="{{ route('auth.login') }}" method="post" class="bloc-form__form form--login">
                @csrf
                <div class="form__bloc-verif bloc-verif--login">
                    <!-- Email -->
                    <input type="text" @class(['form-input', 'input--username', 'placeholder' => $errors->has('login')]) name="login" placeholder="Nom d'utilisateur ou adresse e-mail" value="{{ old('login') }}">
                    @error("login")
                        <p class="p-danger"> {{ $message }} </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form__bloc-verif">
                    <input type="password" @class(['form-input', 'input--password', 'placeholder' => $errors->has('password')]) name="password" placeholder="Mot de passe">
                    @error("password")
                        <p class="p-danger"> {{ $message }} </p>
                    @enderror
                    <div class="bloc-pswd__btn-hide-show btn-hide-show--password"><i class="ri ri-eye-off-fill"></i></div>
                </div>

                {{-- Se souvenir de moi et mot de passe oublié --}}
                <div class="form__bloc-meta">
                    <div class="remember">
                        <input type="checkbox" name="remember" id="remember" class="rember__checkbox" {{ old('remember') ? 'checked' : '' }} >
                        <label for="remember" class="remember__text">Se souvenir de moi</label>
                    </div>

                    <div class="forgotpassword">
                        <a href="#" class="forgotpassword__link">Mot de passe oublié ?</a>
                    </div>
                </div>

                <!-- Button -->
                <div class="vstack form__bloc-btn">
                    <button type="submit" class="btn btn-primary btn--login">Se connecter</button>
                </div>


            </form>
            <!-- Link -->
            <p class="bloc-form__link">
                Vous n'avez pas de compte ?
                <a class="link-primary" href="{{ route('auth.signup') }}">Créez un compte</a>
            </p>
        </div>
    </div>
@endsection
