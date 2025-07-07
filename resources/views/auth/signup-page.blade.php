@extends('auth.master-auth')

@section('title_page')
Inscription
@endsection

@section('text--title')
Rejoignez notre communauté
@endsection

@section('text--paragraph')
Likez vos articles préférés, laissez des commentaires <br> et même
publiez vos propres articles  pour partager <br>vos idées avec le monde.
@endsection

@section('content')
    <!-- Formulaire -->
    <div class="content-form">
        <div class="content-form__bloc">
            <!-- TItre -->
            <div class="bloc-form__title">
                <p class="title__h">Créer un compte</p>
                <p class="title__p">Entrez vos données personnelles pour créer votre compte.</p>
            </div>
            <!-- Formulaire -->
            <form action="{{ route('auth.signup') }}" method="post" class="bloc-form__form">
                @csrf
                {{-- <div class="form__bloc-verif">
                    <div class="form__bloc">
                        <!-- Nom -->
                        <input type="text" @class(['form-input', 'input--firstname', 'placeholder' => $errors->has('firstname') ]) name="firstname" placeholder="Prénom" value="{{ old('firstname') }}">
                        <!-- Post-nom -->
                        <input type="text" @class(['form-input', 'placeholder' => $errors->has('lastname')]) name="lastname" placeholder="Nom" value="{{ old('lastname') }}">
                    </div>
                    @error("firstname")
                        <p class="p-danger"> {{ $message }} </p>
                    @enderror
                    @error("lastname")
                        <p class="p-danger"> {{ $message }} </p>
                    @enderror
                </div> --}}

                <div class="form__bloc-verif">
                    <!-- Nom -->
                    <input type="text" @class(['form-input', 'input--firstname', 'placeholder' => $errors->has('firstname') ]) name="firstname" placeholder="Prénom" value="{{ old('firstname') }}">
                    @error("firstname")
                        <p class="p-danger"> {{ $message }} </p>
                    @enderror
                </div>

                <div class="form__bloc-verif">
                    <!-- Post-nom -->
                    <input type="text" @class(['form-input', 'placeholder' => $errors->has('lastname')]) name="lastname" placeholder="Nom" value="{{ old('lastname') }}">
                    @error("lastname")
                        <p class="p-danger"> {{ $message }} </p>
                    @enderror
                </div>

                <div class="form__bloc-verif">
                    <!-- Email -->
                    <input type="email" @class(['form-input', 'input--email', 'placeholder' => $errors->has('email')]) name="email" placeholder="Email" value="{{ old('email') }}">
                    @error("email")
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
                <!-- Confirm password -->
                <div class="form__bloc-verif">
                    <input type="password" @class(['form-input', 'input--confirm-password', 'placeholder' => $errors->has('confirm_password')]) name="password_confirmation" placeholder="Confirmer le mot de passe">
                    @error("confirm_password")
                        <p class="p-danger"> {{ $message }} </p>
                    @enderror
                    <div class="bloc-pswd__btn-hide-show btn-hide-show--confirm-password"><i class="ri ri-eye-off-fill"></i></div>
                </div>
                <!-- Button -->
                <div class="vstack form__bloc-btn">
                    <button type="submit" class="btn btn-primary">Créer un compte</button>
                </div>
            </form>
            <!-- Link -->
            <p class="bloc-form__link">
                Vous avez déjà un compte ?
                <a class="link-primary" href="{{ route('auth.login') }}">Connectez-vous</a>
            </p>
        </div>
    </div>
@endsection
