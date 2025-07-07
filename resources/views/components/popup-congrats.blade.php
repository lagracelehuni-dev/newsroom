<div class="popup popup--{{ $type }}">
    @php
        $title = 'Félicitations !';
        $message = "Merci de rejoindre notre communauté.
            Vous pouvez dès maintenant découvrir, créer et partager des articles sur les sujets qui vous passionnent.";
    @endphp
    

    <div class="popup__content">
        <p class="popup__title">{{ $title }}</p>
        <p class="popup__message">
            {{ $message }}
        </p>
        <form action="{{ route('closeCongrats', Auth::user()->id) }}" method="post">
            @csrf
            {{-- <input type="hidden" name="userId" value="{{ Auth::user()->id }}" hidden> --}}
            <button type="submit" class="popup__close">
                <i class="ri ri-close-fill"></i>
            </button>
        </form>
        
    </div>
</div>