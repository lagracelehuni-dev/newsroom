<div class="popup popup--{{ $type }}">
    @php
        $title = 'Action requise !';
        $message = "
                Cette fonctionnalité est réservée aux membres.
                Connectez-vous ou inscrivez-vous pour continuer.";
    @endphp

    <div class="popup__content">
        <p class="popup__title">{{ $title }}</p>
        <p class="popup__message">
            {{ $message }}
        </p>

        <div class="popup__stacks hstack">
            <a href="{{ route('auth.signup') }}" class="btn btn-outlined-secondary">Créer un compte</a>
            <a href="{{ route('auth.login') }}" class="btn btn-primary" >Se connecter</a>
        </div>
        
        <button class="popup__close">
            <i class="ri ri-close-fill"></i>
        </button>
    </div>

</div>