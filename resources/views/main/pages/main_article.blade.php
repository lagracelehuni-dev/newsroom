@extends('main.master-main')

@section('main')



<div class="section section--home section--scroll">
    <div class="section__header">
        @php
            $previous = url()->previous();
            $isArtDet = str_contains($previous, route('home*'));
            $closeUrl = $isArtDet ? route('home') : $previous;
        @endphp
        <a href="{{ $closeUrl }}"  class="section__back"><i class="ri ri-arrow-left-line"></i></a>
        <p class="section__category-title">@yield('article.header_title')</p>
    </div>
    <x-navbar-top>@yield('article.header_title')</x-navbar-top>

    @yield('article')

</div>

@endsection

@section('sidebar')
<div class="sidebar__content">
    @include('partials.sidebarContent')
</div>
@endsection
