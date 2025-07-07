@extends('main.master-main')

@section('main')
@yield('home')
@endsection

@section('sidebar')

<div class="sidebar__content">
    @include('partials.sidebarContent')
</div>

@endsection

