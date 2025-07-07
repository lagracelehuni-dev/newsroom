<div class="avatar-import {{ $extraClass ?? '' }}">
    <input type="file" name="{{ $inputName ?? 'avatar' }}" class="avatar-import__input {{ $inputClass ?? '' }}" accept="image/jpeg,image/jpg,image/png" hidden>
    <div class="avatar-import__preview {{ $previewClass ?? '' }}">
        <img src="{{ $imgProfil ?? '' }}" alt="Aperçu de l'image">
    </div>
    <div class="avatar-import__browse {{ $btnClass ?? '' }}" data-title="Importer une image"><i class="ri ri-image-fill ri-lg"></i> {{ $nameBtn ?? '' }} </div>
</div>
