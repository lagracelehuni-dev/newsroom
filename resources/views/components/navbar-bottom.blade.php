<div class="navbar-bottom">
    <div class="navbar__tabs">
        <ul class="navbar__tabs-ul">
            <li class="navbar__tabs-li">
                <a href="{{ route('home') }}" class="navbar__tabs-link {{ request()->is('home*') ? 'is-active' : '' }}">
                    <i class="ri ri-home-5-{{ request()->is('home*') ? 'fill' : 'line' }}"></i>
                    <span class="navbar__tabs-text">Accueil</span>
                </a>
            </li>
            <li class="navbar__tabs-li">
                <a href="{{ route('search') }}" class="navbar__tabs-link {{ request()->is('search*') ? 'is-active' : '' }}">
                    <i class="ri ri-search-2-{{ request()->is('search*') ? 'fill' : 'line' }}"></i>
                    <span class="navbar__tabs-text">Recherhce</span>
                </a>
            </li>
            <li class="navbar__tabs-li">
                <a href="{{ route('compose') }}" class="navbar__tabs-link tab--compose {{ request()->is('compose') ? 'is-active' : '' }}">
                    <i class="ri ri-add-fill"></i>
                    <span class="navbar__tabs-text">Rediger</span>
                </a>
            </li>
            <li class="navbar__tabs-li">
                <a href="{{ route('bookmarks.index') }}" class="navbar__tabs-link {{ request()->is('bookmarks*') ? 'is-active' : '' }}">
                    <i class="ri ri-bookmark-{{ request()->is('bookmarks*') ? 'fill' : 'line' }}"></i>
                    <span class="navbar__tabs-text">Bookmarks</span>
                </a>
            </li>
            <li class="navbar__tabs-li">
                <a href="{{ route('profil', ['username' => Auth::check() ? Auth::user()->username : '*']) }}" class="navbar__tabs-link {{ Auth::check() && request()->is('profil/' . Auth::user()->username) ? 'is-active' : '' }}">
                    <i class="ri ri-user-3-{{ Auth::check() && request()->is('profil/' . Auth::user()->username) ? 'fill' : 'line' }}"></i>
                    <span class="navbar__tabs-text">Profil</span>
                </a>
            </li>
        </ul>
    </div>
</div>
