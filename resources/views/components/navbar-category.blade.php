<div class="navbar navbar--category">
   <div class="navbar__list">
        <ul class="navbar__list-ul">

            <li class="navbar__list-li">
                <a href="{{ route('home') }}" class="navbar__list-link {{ request()->is('home') ? 'is-active' : '' }}">
                    <span class="navbar__list-text">Toutes</span>
                </a>
            </li>



            @foreach ($categories as $category)
                @if($category->slug)
                <li class="navbar__list-li">
                    <a href="{{ route('category', ['category' => $category->slug]) }}" class="navbar__list-link {{ request()->is('home/category/' . $category->slug) ? 'is-active' : '' }}">
                        <span class="navbar__list-text">
                            {{ $category->name }}
                        </span>
                    </a>
                </li>
                @else
                <li class="navbar__list-li">
                    <span class="navbar__list-link">
                        <span class="navbar__list-text">
                            {{ $category->name }}
                        </span>
                    </span>
                </li>
                @endif
            @endforeach
        </ul>
   </div>
</div>
