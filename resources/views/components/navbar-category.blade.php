<div class="navbar navbar--category">
   <div class="navbar__list">
        <ul class="navbar__list-ul">

            <li class="navbar__list-li">
                <a href="{{ route('home') }}" class="navbar__list-link {{ request()->is('home') ? 'is-active' : '' }}">
                    <span class="navbar__list-text">Toutes</span>
                </a>
            </li>

            @php
                $activeCategory = null;
                $otherCategories = collect();
                
                foreach ($categories as $category) {
                    if (request()->is('home/category/' . $category->slug)) {
                        $activeCategory = $category;
                    } else {
                        $otherCategories->push($category);
                    }
                }
            @endphp

            {{-- Afficher d'abord la catégorie active --}}
            @if($activeCategory)
                <li class="navbar__list-li">
                    <a href="{{ route('category', ['category' => $activeCategory->slug]) }}" class="navbar__list-link is-active">
                        <span class="navbar__list-text">
                            {{ $activeCategory->name }}
                        </span>
                    </a>
                </li>
            @endif

            {{-- Puis afficher les autres catégories --}}
            @foreach ($otherCategories as $category)
                @if($category->slug)
                <li class="navbar__list-li">
                    <a href="{{ route('category', ['category' => $category->slug]) }}" class="navbar__list-link">
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
