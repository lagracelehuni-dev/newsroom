<div class="pannel-auth">

    <div class="pannel-auth__container">
        <button type="button" class="pannel-auth__close"><i class="ri ri-close-fill"></i></button>

        @auth
            <div class="pannel-auth__meta-pannel">
                <div class="pannel-accounts">
                    {{-- Compte actif --}}
                    <a href="{{ route('profil', ['username' => Auth::check() ? Auth::user()->username : '*']) }}" class="account account--is-active">
                        <div class="account__content">
                            <div class="account__avatar">
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="photo de profil">
                            </div>
                            <div class="account__infos">
                                <p class="account__name">{{ Auth::user()->first_name . " " . Auth::user()->last_name }}</p>
                                <p class="account__username">{{ "@" . Auth::user()->username }}</p>
                            </div>
                        </div>
                        <div class="account__active">
                            <i class="ri ri-checkbox-circle-fill ri-lg"></i>
                        </div>
                    </a>

                    {{-- Comptes non actifs >= 5 --}}
                    {{-- @for ($i = 0; $i < 2; $i++)
                    <a href="#" class="account account--is-not-active">
                        <div class="account__content">
                            <div class="account__avatar">
                                <img src="{{ asset("avatar/default_avatar.jpg") }}" alt="photo de profil">
                            </div>
                            <div class="account__infos">
                                <p class="account__name">LaGrace Lehuni {{$i + 1}}</p>
                                <p class="account__username">@developer456</p>
                            </div>
                        </div>
                        <div class="account__notif">
                            <p>
                                {{ random_int(1, 99) }}
                            </p>
                        </div>
                    </a>
                    @endfor --}}

                    {{-- Voir plus --}}
                    {{-- <a href="#" class="account-more">Voir plus <i class="ri ri-arrow-drop-right-line ri-xl"></i></a> --}}
                </div>
                <div class="pannel-body">
                    <ul class="pannel-body__menu">
                        {{-- <li><a href="{{ route('auth.login') }}" class="pannel-body__item">Ajouter un compte existant</a></li> --}}
                        <li><a href="#" class="pannel-body__item">Supprimer le compte</a></li>
                        <li>
                            <form action="{{ route('auth.logout') }}" method="post">
                                @method("delete")
                                @csrf
                                <button class="pannel-body__item pannel-body--last">Se déconnecter de {{ "@" . Auth::user()->username }}</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @endauth

        @guest
            <div class="vstack pannel-auth__bloc">
                <a href="{{ route('auth.signup') }}" class="btn btn-outlined-secondary">Créer un compte</a>
                <a href="{{ route('auth.login') }}" class="btn btn-primary">Se connecter</a>
            </div>
        @endguest
    </div>
</div>
