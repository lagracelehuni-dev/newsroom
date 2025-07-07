@extends('main.master-main')

@section('main')

<div class="section section--home section--scroll">
    <div class="section__header">
        @php
            $previous = url()->previous();
            $isArtDet = str_contains($previous, route('profil', ['username' => Auth::check() ? Auth::user()->username : '*']));
            $closeUrl = $isArtDet ? route('home') : $previous;
        @endphp
        <button type="button" class="section__back trigger-back"><i class="ri ri-arrow-left-line"></i></button>
        <p class="section__category-title">Profil</p>
    </div>
    <x-navbar-top>Profil</x-navbar-top>

    <div class="profil__body">
        {{-- Infos de l'utilisateur --}}
        <div class="profil__user-infos">
            {{-- Profil de l'utilisateur --}}
            <div class="profil__avatar">
                <div class="profil__avatar-bloc-photo lightbox-trigger" data-img="{{ $user->avatar ? asset($user->avatar) : asset('assets/img/profil/default.jpg') }}">
                    <img src="{{ $user->avatar ? asset($user->avatar) : asset('assets/img/profil/default.jpg') }}" class="avatar__img" alt="Avatar de l'utilisateur">
                </div>
            </div>
            {{-- Les cooerdonnés de l'utilisateur --}}
            <div class="profil__informations">
                <div class="infos__principals border--bottom">
                    <p class="profil__fullname">{{ $user->first_name . " " . $user->last_name }}</p>
                    <p class="profil__username">{{ "@" . $user->username }}</p>
                </div>
                <div class="infos__principals border--bottom">
                    <p class="profil__bio is-truncated">{{ $user->bio ?? "..." }}</p>

                </div>
                <div class="infos__principals border--bottom">
                    <p class="profil__location">
                        <i class="ri ri-map-pin-fill"></i>
                        {{ $user->location ?? "..." }}
                    </p>
                    <p class="profil__website">
                        <i class="ri ri-global-fill"></i>
                        <a {{ $user->website ? "href=" . $user->website : '' }} target="_blank" rel="noopener noreferrer">
                            {{ $user->website ?? "..." }}
                        </a>
                    </p>
                </div>

                {{-- Bouton édition profil --}}
                @if (Auth::check() && Auth::user()->id === $user->id)
                    <div class="profil__btn-edit">
                        <a href="{{ route('profil.edit', ['username' => Auth::check() ? Auth::user()->username : '*']) }}" class="btn-sm btn-outlined-secondary">Modifier le profil</a>
                    </div>
                @endif

            </div>

        </div>

        {{-- Les aticles de l'utilisateurs --}}
        <div class="profil__user-articles">
            <div class="profil__user-articles-header">
                <p class="profil__user-count count--articles">{{ $postsCount > 1 ? $postsCount . " articles" : $postsCount . " article"  }}</p>
                <p class="profil__user-count count--views">{{ $viewsCount > 1 ? $viewsCount . " lectures" : $viewsCount . " lecture" }}</p>
            </div>
            @if ($postsCount > 0)
                {{-- Liste des articles --}}
                <div class="article-list">
                    @include('partials.postBloc')
                </div>
                @if ($postsCount > 5)
                {{-- Bouton pour charger plus d'articles --}}
                <div class="bloc__btn-loadmore">
                    <button class="btn-loadmore btn-loadmore--home" data-username="{{ $user->username }}">Afficher plus d’articles <i class="ri ri-arrow-right-s-line"></i></button>
                </div>
                @endif
            @else
                <div class="profil__no-articles">
                    <p class="profil__no-articles-text">Aucun article publié.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@section('sidebar')
    <div class="sidebar__content">
        @include('partials.sidebarContent')
    </div>
@endsection
