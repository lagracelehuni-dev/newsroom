<div class="navbar navbar--top">
    @php

        $actionReact = Auth::check() ? 'action-react' : 'popup-trigger';

    @endphp

    <div class="nav-flex">
        @if (request()->is('home*'))
        <div class="navbar__logo">
            <img class="navbar__img" src="{{ asset('assets/img/@favicon__newsroom--v5.png') }}" alt="Newsroom__icon">
        </div>
        @else
        <div class="navbar__back">
            <button type="button" class="trigger-back navbar__back-btn">
                <i class="ri ri-arrow-left-line"></i>
            </button>
        </div>
        @endif
        <div class="navbar__title">
            <p class="navbar__title-p"> {{ $slot }} </p>
        </div>
    </div>

    <div class="nav-flex">
        @if(Auth::check())
            <div class="navbar__link">
                <a
                    @if(Auth::check())
                        href="{{ route('notifications.index') }}"
                    @endif
                    @class([
                        $actionReact,
                        'navbar__link-notif',
                        'is-active' => request()->is('notifications*')
                    ])
                >
                    <i class="ri ri-notification-2-{{ request()->is('notifications*') ? 'fill' : 'line' }}"></i>

                    @if(Auth::check() && auth()->user()->unreadNotifications->count() > 0)
                        <span class="navbar__link-notif-count position--type1">
                            {{ auth()->user()->unreadNotifications->count() > 99 ? '99+' : auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
            </div>
        @elseif (!Auth::check() && request()->is('home*'))
            <div class="navbar__link">
                <button class="navbar__link-notif trigger-search">
                    <i class="ri ri-search-line"></i>
                </button>
            </div>
        @endif
        <div class="navbar__btn">
            <button type="button" class="navbar__btn-neutral trigger-sidebar">
                <i class="ri ri-more-fill ri-lg"></i>
            </button>
        </div>
    </div>
</div>
