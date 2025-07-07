<div class="bloc__fixed">
    <div class="bloc__absolute">
        <div class="section section--edit section--scroll">
            <div class="section__header section__header--compose compose--header">
                <p class="section__title compose--title">Modifier le profil</p>
                <button type="button" class="section__header-close trigger-back"> <i class="ri ri-close-fill"></i> </button>
            </div>

            <form class="edit-profil__body" action="{{ route('profil.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- Edit avatar --}}
                <div class="edit-profil__avatar">
                    <div class="avatar__import">
                        <input type="file" name="avatar" class="avatar-import__input" accept="image/jpeg,image/jpg,image/png" hidden>
                        <div class="avatar-import__preview">
                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('assets/img/profil/default.jpg') }}" alt="Aperçu de l'image">
                        </div>
                        <button type="button" class="avatar-import__browse" data-title="Importer une image">
                            <span><i class="ri ri-camera-line"></i></span>
                        </button>
                    </div>
                    @error('avatar__input')
                        <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                    @enderror
                    {{-- <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> Allo</p> --}}
                </div>

                {{-- Edit user informations --}}
                <div class="edit-profil__others-infos">
                    {{-- Edit firstname --}}
                    <div class="edit-profil__input">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" class="edit-profil__input-field" value="{{ old('first_name', $user->first_name) }}" placeholder="Votre prénom">
                        @error('first_name')
                            <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Edit lastname --}}
                    <div class="edit-profil__input">
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" class="edit-profil__input-field" value="{{ old('last_name', $user->last_name) }}" placeholder="Votre nom">
                        @error('last_name')
                            <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Edit username --}}
                    <div class="edit-profil__input">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" name="username" id="username" class="edit-profil__input-field" value="{{ old('username', $user->username) }}" placeholder="Votre nom d'utilisateur">
                        @error('username')
                            <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Edit email --}}
                    <div class="edit-profil__input">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" name="email" id="email" class="edit-profil__input-field" value="{{ old('email', $user->email) }}" placeholder="Votre adresse e-mail">
                        @error('email')
                            <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Edit bio --}}
                    <div class="edit-profil__input">
                        <label for="bio">Biographie</label>
                        <textarea name="bio" id="bio" class="edit-profil__input-field" rows="3" placeholder="Parlez-nous de vous...">{{ old('bio', $user->bio) }}</textarea>
                        <small>Max : 160 caractères</small>
                        @error('bio')
                            <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Edit location --}}
                    <div class="edit-profil__input">
                        <label for="location">Localisation</label>
                        <input type="text" name="location" id="location" class="edit-profil__input-field" value="{{ old('location', $user->location) }}" placeholder="Votre localisation">
                        @error('location')
                            <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Edit website --}}
                    <div class="edit-profil__input">
                        <label for="website">Site web</label>
                        <input type="url" name="website" id="website" class="edit-profil__input-field" value="{{ old('website', $user->website) }}" placeholder="Votre site web">
                        @error('website')
                            <p class="edit-profil__error"><i class="ri-error-warning-fill"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Reset password --}}
                    <div class="edit-profil__reset-pswd">
                        <a href="{{ route('password.reset') }}" class="reset-pswd__link">Réinitialisez votre mot de passe</a>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="edit-profil__actions hstack">
                    <button type="submit" class="btn btn-outlined-primary">Enregistrer</button>
                    <button type="button" class="btn btn-outlined-secondary trigger-back">Annuler</button>
                </div>
            </form>

        </div>

    </div>
</div>
