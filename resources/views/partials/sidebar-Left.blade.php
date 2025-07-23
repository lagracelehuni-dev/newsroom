<section class="sidebar sidebar--left">

    <div class="sidebar__logo">
        <div class="logo__img-bloc">
            <img src="{{ asset('assets/img/@logo__newsroom--v6.png') }}" class="img-desktop" alt="logo">
        </div>
    </div>

    <div class="siderbar__nav">
        <ul>
            <li><a @class(["nav-link", "is-active" => request()->is('home*')]) data-icon="home-5-line" data-icon-fill="home-5-fill" href="{{ route('home') }}"><i class="ri ri-home-5-line"></i> Accueil</a></li>
            <li><a @class(["nav-link", "is-active" => request()->is('search*')])  data-icon="search-2-line" data-icon-fill="search-2-fill" href="{{ route('search') }}"><i class="ri ri-search-2-line"></i> Recherche</a></li>
            <li>
                <a
                    @class([
                        'nav-link',
                        $actionReact,
                        'notif--relative',
                        'is-active' => request()->is('notifications*'),
                    ])
                    data-icon="notification-2-line"
                    data-icon-fill="notification-2-fill"
                    @if(Auth::check())
                        href="{{ route('notifications.index') }}"
                    @endif
                >
                    <i class="ri ri-notification-2-line"></i>
                    @if(Auth::check() && auth()->user()->unreadNotifications->count() > 0)
                        <span class="navbar__link-notif-count position--type2">
                            {{ auth()->user()->unreadNotifications->count() > 99 ? '99+' : auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif

                    Notifications
                </a>
            </li>

            <li><a @class(["nav-link","$actionReact", "is-active" => request()->is('bookmarks*')])  data-icon="bookmark-line" data-icon-fill="bookmark-fill" {{ Auth::check() ? ("href=" . route('bookmarks.index')) : "" }}><i class="ri ri-bookmark-line"></i> Enregistrements</a></li>

            <li><a @class(["nav-link","$actionReact", "is-active" => Auth::check() && request()->is('profil/' . Auth::user()->username)]) data-icon="user-3-line" data-icon-fill="user-3-fill" {{ Auth::check() ? ("href=" . route('profil', ['username' => Auth::check() ? Auth::user()->username : '*'])) : "" }}><i class="ri ri-user-3-line"></i> Profil</a></li>

            <li><a @class(["nav-link--edit","$actionReact", "is-active" =>  request()->is('compose*')]) {{ Auth::check() ? ("href=" . route('compose')) : "" }}>Rediger</a></li>
        </ul>
    </div>

    <div class="sidebar__stack">
        @auth
            <div class="stack__meta">
                <div class="stack__meta-content">
                    <div class="stack__meta-avatar">
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Photo de profil">
                    </div>
                    <div class="stack__meta-infos">
                        <p class="stack__meta-name">{{ Auth::user()->first_name . " " . Auth::user()->last_name }}</p>
                        <p class="stack__user-name">{{ "@" . Auth::user()->username }}</p>
                    </div>
                </div>
                <button class="stack__meta-more auth-trigger">
                    <i class="ri ri-more-fill ri-lg"></i>
                    <span></span>
                </button>
                <div class="stack__meta-pannel">
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
                            <li><button type="button" class="pannel-body__item trigger-open-sd">Supprimer le compte</button></li>
                            <li>
                                <button type="button" class="pannel-body__item pannel-body--last trigger-open">Se déconnecter de {{ "@" . Auth::user()->username }}</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endauth

        @guest
            <div class="vstack stack__bloc">
                <a href="{{ route('auth.signup') }}" class="btn btn-outlined-secondary">Créer un compte</a>
                <a href="{{ route('auth.login') }}" class="btn btn-primary">Se connecter</a>
            </div>
        @endguest

    </div>
</section>

<section class="sidebar sidebar--condense">

    <div class="sidebar__logo sidebar__logo--condense">
        <div class="logo__img-bloc">
            <img src="{{ asset('assets/img/@favicon__newsroom--v5.png') }}" alt="logo">
        </div>
    </div>

    <div class="siderbar__nav siderbar__nav--condense">
        <ul>
            <li><a @class(["nav-link","tooltip tooltip--top-left", "is-active" => request()->is('home*')]) data-icon="home-5-line" data-icon-fill="home-5-fill" href="{{ route('home') }}" data-title="Accueil"><i class="ri ri-home-5-line"></i></a></li>
            <li><a @class(["nav-link","tooltip tooltip--top-left", "is-active" => request()->is('search*')])  data-icon="search-2-line" data-icon-fill="search-2-fill" href="{{ route('search') }}" data-title="Recherche"><i class="ri ri-search-2-line"></i></a></li>
            <li>
                <a
                    @class([
                        'nav-link tooltip tooltip--top-left',
                        $actionReact,
                        'notif--relative',
                        'is-active' => request()->is('notifications*'),
                    ])
                    data-icon="notification-2-line"
                    data-icon-fill="notification-2-fill"
                    @if(Auth::check())
                        href="{{ route('notifications.index') }}"
                    @endif
                    data-title="Notifications"
                >
                    <i class="ri ri-notification-2-line"></i>
                    @if(Auth::check() && auth()->user()->unreadNotifications->count() > 0)
                        <span class="navbar__link-notif-count position--type2">
                            {{ auth()->user()->unreadNotifications->count() > 99 ? '99+' : auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
            </li>

            <li><a @class(["nav-link tooltip tooltip--top-left","$actionReact", "is-active" => request()->is('bookmarks*')])  data-icon="bookmark-line" data-icon-fill="bookmark-fill" {{ Auth::check() ? ("href=" . route('bookmarks.index')) : "" }} data-title="Enregistrements"><i class="ri ri-bookmark-line"></i></a></li>

            <li><a @class(["nav-link tooltip tooltip--top-left","$actionReact", "is-active" => Auth::check() && request()->is('profil/' . Auth::user()->username)]) data-icon="user-3-line" data-icon-fill="user-3-fill" {{ Auth::check() ? ("href=" . route('profil', ['username' => Auth::check() ? Auth::user()->username : '*'])) : "" }} data-title="Profil"><i class="ri ri-user-3-line"></i></a></li>

            <li><a @class(["nav-link--edit tooltip tooltip--top-left","$actionReact", "is-active" =>  request()->is('compose*')]) {{ Auth::check() ? ("href=" . route('compose')) : "" }} data-title="Rediger"><i class="ri ri-add-line"></i></a></li>
        </ul>
    </div>

    <div class="sidebar__stack sidebar__stack--condense">
        @auth
            <div class="stack__meta stack__meta--condense">
                <div class="stack__meta-content stack__meta-content--condense auth-trigger">
                    <div class="stack__meta-avatar">
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Photo de profil">
                    </div>
                </div>
                <div class="stack__meta-pannel stack__meta-pannel--condense">
                    <div class="pannel-accounts">
                        {{-- Compte actif --}}
                        <a href="{{ route('profil', ['username' => Auth::check() ? Auth::user()->username : '*']) }}" class="account account--is-active auth-trigger tooltip tooltip--top-left" data-title="Profil">
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
                    </div>
                    <div class="pannel-body">
                        <ul class="pannel-body__menu">
                            {{-- <li><a href="{{ route('auth.login') }}" class="pannel-body__item">Ajouter un compte existant</a></li> --}}
                            <li><button type="button" class="pannel-body__item trigger-open-sd">Supprimer le compte</button></li>
                            <li>
                                <button type="button" class="pannel-body__item pannel-body--last trigger-open">Se déconnecter de {{ "@" . Auth::user()->username }}</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endauth

        @guest
            <div class="vstack stack__bloc">
                <a href="{{ route('auth.signup') }}" class="btn btn-outlined-secondary tooltip tooltip--top-left" data-title="Créer un compte"><i class="ri ri-user-add-line"></i></a>
                <a href="{{ route('auth.login') }}" class="btn btn-primary tooltip tooltip--top-left" data-title="Se connecter"><i class="ri ri-login-circle-line"></i></a>
            </div>
        @endguest

    </div>
</section>
