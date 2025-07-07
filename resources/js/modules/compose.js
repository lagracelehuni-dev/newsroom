import { initImageImport } from './imageImport.js';

// Gestion des champs automatiques (slug et temps de lecture)
document.addEventListener('DOMContentLoaded', function() {
    // Temps de lecture automatique
    const autoCheckbox = document.getElementById('custome-reading-time');
    const manualInput = document.getElementById('compose__reading-time');
    const rdtPlaceholder = 1
    if(autoCheckbox && manualInput) {
        function toggleManualInput() {
            manualInput.disabled = autoCheckbox.checked;
            manualInput.disabled ? manualInput.placeholder = "" : manualInput.placeholder = rdtPlaceholder
        }
        autoCheckbox.addEventListener('change', toggleManualInput);
        toggleManualInput(); // état initial
    }
    // Slug automatique
    const slugAuto = document.getElementById('custom-slug');
    const slugInput = document.getElementById('compose__slug');
    const slugPlaceholder = "Ex: le-titre-de-votre-article"
    if(slugAuto && slugInput) {
        function toggleSlugInput() {
            slugInput.disabled = slugAuto.checked;
            slugInput.disabled ? slugInput.placeholder = "" : slugInput.placeholder = slugPlaceholder
        }
        slugAuto.addEventListener('change', toggleSlugInput);
        toggleSlugInput();
    }
});

// Initialisation de l'import d'images
if (document.querySelector('.compose__import')) {
    initImageImport(document);
}
