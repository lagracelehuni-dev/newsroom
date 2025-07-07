<div class="alert alert--visible alert--{{ $type }}">
    @php
        $icon = null;
        $title = null;

        if ($type == 'success') {
            $icon = 'check';
            $title = 'Succès';
        } else if ($type == 'danger') {
            $icon = 'error-warning';
            $title = 'Erreur';
        } else {
            $icon = 'alert';
            $title = 'Attention';
        }
    @endphp
    <div class="alert__icon">
        <div class="alert__icon-icon">
        <i class="ri ri-{{ $icon }}-line"></i>
        </div>
    </div>
    <div class="alert__content">
        <!-- <p class="alert__content-title"> {{ $title }} </p> -->
        <p class="alert__content-text"> {{ $slot }} </p>
    </div>
    <div class="alert__close"><button type="submit" class="alert__close-btn"><i class="ri ri-close-fill"></i></button></div>
</div>