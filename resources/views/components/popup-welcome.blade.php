<div class="popup popup--{{ $type }}">
    @php
        $title = 'Bienvenue sur Newsroom !';
        $message = "
                Créez un compte gratuitement pour participez pleinement à l'expérience :
                likez vos articles préférés, laissez des commentaires et publiez vos propres
                articles pour partager vos idées avec le monde.";
    @endphp

    <div class="popup__content">
    <p class="popup__title">{{ $title }}</p>
    <p class="popup__message">
        {{ $message }}
    </p>
    
    <a class="popup__links" href="{{ route('auth.signup') }}">Inscrivez-vous dès maintenant et faites entendre votre voix !</a>

    <button class="popup__close">
        <i class="ri ri-close-fill"></i>
    </button>
    </div>

</div>