<div class="bloc__fixed">
    <div class="bloc__absolute">
        <div class="section section--compose section--scroll">
            <div class="section__header section__header--compose compose--header">
                <p class="section__title compose--title">Rédiger un nouvel article</p>
                @php
                    $previous = url()->previous();
                    $isCompose = str_contains($previous, route('compose'));
                    $closeUrl = $isCompose ? route('home') : $previous;
                @endphp
                <a href="{{ $closeUrl }}" class="section__header-close"> <i class="ri ri-close-fill"></i> </a>
            </div>

            <div class="compose__body"></div>
                @if(isset($post) && $post)
                    <form class="compose__form" method="POST" action="{{ route('posts.update') }}" enctype="multipart/form-data">
                @else
                    <form class="compose__form" method="POST" action="#" enctype="multipart/form-data">
                @endif
                    @csrf
                    @method('PUT')
                    <!-- Mettre le titre -->
                    <div class="c-form__bloc bloc-gap">
                        <label for="compose__title">Titre :</label>
                        <input type="text" name="compose__title" id="compose__title" @class(['compose__input', 'error--input' => $errors->has('compose__title')]) value="{{ isset($post) ? old('compose__title', $post->title) : old('compose__title') }}" placeholder="Ex: Le titre de votre article">
                        <!-- Message d'erreur -->
                        @error("compose__title")
                            <p class="p--error"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
                        @enderror
                    </div>
                    <!-- Slug & slug automatique -->
                    <div class="c-form__bloc bloc-gap">
                            <!-- Mettre le slug -->
                            <div class="slug">
                                <label for="compose__slug">Slug :</label>
                                <input type="text" name="compose__slug" id="compose__slug" @class(['compose__input', 'error--input' => $errors->has('compose__slug')]) value="{{ isset($post) ? old('compose__slug', $post->slug) : old('compose__slug') }}" placeholder="Ex: le-titre-de-votre-article">
                            </div>

                            <!-- Message d'erreur -->
                            @error("compose__slug")
                                <p class="p--error"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
                            @enderror

                            <!-- Slug automatique -->
                            <div class="checkbox custom-slug">
                                <input type="checkbox" name="compose__custom-slug" id="custom-slug" class="checkbox__bloc" {{ old('compose__custom-slug') ? 'checked' : '' }} >
                                <label for="custom-slug" class="checkbox__text">Slug automatique</label>
                            </div>
                    </div>

                    <!-- Contenu -->
                    <div class="c-form__bloc bloc-gap">
                        <label for="compose__content">Contenu :</label>
                        <textarea name="compose__content" id="compose__content" @class(['compose__textarea', 'error--textarea' => $errors->has('compose__content')]) placeholder="Écrivez votre article ici..." rows="10">{{ isset($post) ? old('compose__content', $post->content) : old('compose__content') }}</textarea>
                        <!-- Message d'erreur -->
                        @error("compose__content")
                            <p class="p--error"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
                        @enderror
                    </div>

                    <!-- Sélection d'une catégorie -->
                    <div class="c-form__bloc bloc-category">
                        {{-- Categorie existante --}}
                        <div class="category__bloc">
                            <p>Catégorie existante:</p>
                            <div class="category__bloc-content">
                                <div @class(['category__button', 'error--category' => $errors->has('compose__category')])>Sélectionner une catégorie <i class="ri ri-arrow-drop-down-line ri-2x"></i></div>
                                <div class="category__content">
                                @if(isset($categories) && count($categories))
                                    @foreach ($categories as $category)
                                        <input type="radio" name="compose__category" id="compose__category-{{ $category->id }}" value="{{ $category->id }}" class="compose__radio" {{ old('compose__category', isset($post) ? $post->category_id : null) == $category->id ? 'checked' : '' }}>
                                        <label for="compose__category-{{ $category->id }}" class="compose__item">{{ $category->name }}</label>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                            <!-- Message d'erreur -->
                            @error("compose__category")
                                <p class="p--error"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
                            @enderror
                        </div>

                        {{-- Nouvelle catégorie --}}
                        <div class="category__bloc">
                            <label for="compose__new-category">Nouvelle catégorie:</label>
                            <div class="category__bloc-content">
                                <input type="text" name="compose__new-category" id="compose__new-category" @class(['compose__input', 'error--input' => $errors->has('compose__new-category')]) value="{{ old('compose__new-category') }}" placeholder="Ex: Ma nouvelle catégorie">
                                <!-- Message d'erreur -->
                                @error("compose__new-category")
                                    <p class="p--error"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Temps de lecture -->
                    <div class="c-form__bloc bloc-gap">
                        <!-- Mettre le temps de lecture -->
                        <label for="compose__reading-time">Temps de lecture (en minutes) :</label>
                        <input type="number" name="compose__reading-time" id="compose__reading-time" @class(['compose__input', 'compose--reading-t','error--input' => $errors->has('compose__reading-time')]) min="1" max="60" value="{{ old('compose__reading-time', $post->reading_time) }}"  placeholder="1">
                        <!-- Message d'erreur -->
                        @error("compose__reading-time")
                            <p class="p--error"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
                        @enderror
                        <!-- Temps de lecture automatique -->
                        <div class="checkbox custome-reading-time">
                            <input type="checkbox" name="compose__custome-reading-time" id="custome-reading-time" class="checkbox__bloc" {{ old('compose__custome-reading-time') ? 'checked' : '' }} >
                            <label for="custome-reading-time" class="custome-reading-time__text">Temps de lecture automatique</label>
                        </div>
                    </div>

                    <!-- Importer une photo (optionnelle) -->
                    <div class="c-form__bloc">
                        <x-image-import
                            name="compose__cover-image"
                            previewClass="compose__import-preview"
                            btnClass="compose__import-btn btn btn-outlined-secondary "
                            extraClass="compose__import"
                            btnClose="compose__import-close"
                        >Importer une photo de couverture
                        </x-image-import>

                        @error("compose__cover-image")
                            <p class="p--error"><i class="ri-error-warning-fill"></i> {{ $message }} </p>
                        @enderror
                        @if(isset($post) && $post->cover_image)
                            <div class="compose__import-preview-box">
                                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="Image actuelle" class="compose__import-preview-img">
                                <p class="compose__import-preview-label">Image actuelle</p>
                            </div>
                        @endif
                    </div>
                    <!-- Bouton publier -->
                    <div class="vstack sticky--bottom">
                        <button type="submit" class="compose__button btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

