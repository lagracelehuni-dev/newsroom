{{-- Composant universel pour l'import d'image, réutilisable partout --}}
<div class="image-import {{ $extraClass ?? '' }}">
    <input type="file" name="{{ $name ?? 'image' }}" class="image-import__input {{ $inputClass ?? '' }}" accept="image/jpeg,image/jpg,image/png" hidden>
    <div class="image-import__preview {{ $previewClass ?? '' }}" style="display:none;">
        <img src="{{ $imgSrc ?? '' }}" alt="Aperçu de l'image">
    </div>
    <div class="image-import__browse {{ $btnClass ?? '' }}" data-title="Importer une image"><i class="ri ri-image-fill ri-lg"></i> {{ $slot ?? '' }} </div>
    <div class="image-import__close {{ $btnClose ?? '' }}" style="display:none;"><i class="ri ri-close-fill"></i></div>
</div>
