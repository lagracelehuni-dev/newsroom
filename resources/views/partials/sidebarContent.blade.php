{{-- Barre de recherche --}}
<div class="sidebar__searchbar">
    <button type="button" class="sidebar__close">
        <i class="ri ri-close-fill"></i>
        {{-- <span>Retourner</span> --}}
    </button>
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

{{-- Categories --}}
<div class="sidebar__categories">
    <p class="category__title">Categories</p>
    <div class="category__content">
        <a href="{{ route('home') }}" class="category__item {{ request()->is('home') ? "category--active" : "" }}">
            <div class="category__meta">
                <p class="category__text">Toutes</p>
                <p class="category__nbr-articles">{{ $allPost->count() . " articles" }}</p>
            </div>
            <div class="category__icon"><i class="ri ri-arrow-drop-right-line ri-xl"></i></div>
        </a>
        @foreach ($categories as $category)
            @if($category->slug)
            <a href="{{ route('category', ['category' => $category->slug]) }}" class="category__item {{ request()->is('home/category/' . $category->slug) ? 'category--active' : '' }}">
                <div class="category__meta">
                    <p class="category__text">{{ $category->name }}</p>
                    <p class="category__nbr-articles">{{ $category->posts_count > 1 ? number_format($category->posts_count) . " articles" : number_format($category->posts_count) . " article" }}</p>
                </div>
                <div class="category__icon"><i class="ri ri-arrow-drop-right-line ri-xl"></i></div>
            </a>
            @else
            <span class="category__item">
                <div class="category__meta">
                    <p class="category__text">{{ $category->name }}</p>
                    <p class="category__nbr-articles">{{ $category->posts_count > 1 ? number_format($category->posts_count) . " articles" : number_format($category->posts_count) . " article" }}</p>
                </div>
                <div class="category__icon"><i class="ri ri-arrow-drop-right-line ri-xl"></i></div>
            </span>
            @endif
        @endforeach
    </div>
</div>
