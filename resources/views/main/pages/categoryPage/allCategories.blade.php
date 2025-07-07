@extends('main.pages.home')

@section('home')
<div class="section section--home section--scroll">
    <div class="section__header">
        @if (!request()->is('home'))
            @php
                $previous = url()->previous();
                $closeUrl = $previous;
            @endphp
            <button type="button" class="section__back trigger-back"><i class="ri ri-arrow-left-line"></i></button>
        @endif
        <p class="section__category-title">{{ isset($categoryTitle) ? $categoryTitle : 'Pour vous' }}</p>
    </div>
    <x-navbar-top>Newsroom</x-navbar-top>
    <x-navbar-category :categories="$categories" />
    <div class="home__body">
        <div class="article-list">
            @include('partials.postBloc', ['posts' => $posts])
        </div>
        <div class="bloc__btn-loadmore">
            <button class="btn-loadmore btn-loadmore--home">Afficher plus d’articles <i class="ri ri-arrow-right-s-line"></i></button>
        </div>
    </div>
</div>
@endsection
