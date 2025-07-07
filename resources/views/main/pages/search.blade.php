@extends('main.master-main')

@section('main')

<div class="section section--home section--scroll">
    <div class="section__header">
        @php
            $previous = url()->previous();
            $isArtDet = str_contains($previous, route('search'));
            $closeUrl = $isArtDet ? route('home') : $previous;
        @endphp
        <button type="button" class="section__back trigger-back"><i class="ri ri-arrow-left-line"></i></button>
        <p class="section__category-title">Recherches</p>
    </div>
    <x-navbar-top>Recherches</x-navbar-top>

    <div class="search__body">
        {{-- Barre de recherche --}}
        <div class="sidebar__searchbar">
            @if (Auth::check())
                <button type="button" class="sidebar__close" style="display: none">
                    <i class="ri ri-close-fill"></i>
                    {{-- <span>Retourner</span> --}}
                </button>
            @endif
            <form class="searchbar">
                <div class="searchbar__icon searchbar--search"><i class="ri ri-search-line"></i></div>
                <input type="text" class="searchbar__input" name="searchbar" placeholder="Rechercher">
                <button type="reset" class="searchbar__icon searchbar--close"><i class="ri ri-close-line"></i></button>
            </form>
            <div class="display">
                <p class="display__msg">Essayez de rechercher des auteurs, des articles ou des mots-clés.</p>
                <div class="display__content">
                    <div class="display__articles">
                        {{-- <a href="#" class="display__article-item">
                            <div class="display__articles-icon"><i class="ri ri-search-line ri-lg"></i></div>
                            <div class="display__articles-text">
                                <p class="display__articles-title">LaGrace Lehuni</p>
                                <p class="display__articles-category">Art & Design</p>
                            </div>
                        </a> --}}
                    </div>
                    <div class="display__authors">
                        {{-- <a href="#" class="display__author-item">
                            <div class="display__author-avatar">
                                <img src="{{ asset('assets/img/profil/lagracelehuni.jpg') }}" alt="Photo de profil">
                            </div>
                            <div class="display__author-infos">
                                <p class="display__author-name">LaGrace Lehuni</p>
                                <p class="display__author-username">@lagracelehuni</p>
                            </div>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
