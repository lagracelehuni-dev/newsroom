export function initArticleImageImport(parent = document) {
    const imageImports = parent.querySelectorAll('.image-import');
    
    if (imageImports.length === 0) {
        return;
    }

    imageImports.forEach((importBloc, index) => {
        const fileInput = importBloc.querySelector('.image-import__input');
        const imgBloc = importBloc.querySelector('.image-import__preview');
        const browseBtn = importBloc.querySelector('.image-import__browse');
        const closeBtn = importBloc.querySelector('.image-import__close');

        if (!fileInput || !imgBloc || !browseBtn) {
            return;
        }

        // Vérifier si les événements sont déjà attachés
        if (browseBtn.dataset.initialized === 'true') {
            return;
        }

        // Marquer comme initialisé
        browseBtn.dataset.initialized = 'true';

        // Gestion du clic sur le bouton de parcours
        browseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            fileInput.click();
        });

        // Gestion de la sélection de fichier
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validation pour accepter uniquement JPEG, JPG et PNG
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                const fileExtension = file.name.toLowerCase().split('.').pop();
                const allowedExtensions = ['jpg', 'jpeg', 'png'];

                if (allowedTypes.includes(file.type) || allowedExtensions.includes(fileExtension)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = imgBloc.querySelector('img');
                        if (img) {
                            img.src = e.target.result;
                        } else {
                            imgBloc.innerHTML = `<img src="${e.target.result}" alt="Aperçu de l'image">`;
                        }
                        imgBloc.style.display = 'block';
                        if (closeBtn) closeBtn.style.display = 'block';
                        importBloc.classList.add('is-import');
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Veuillez sélectionner une image au format JPEG, JPG ou PNG uniquement.');
                    fileInput.value = '';
                }
            }
        });

        // Gestion de la fermeture de l'aperçu
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                imgBloc.style.display = 'none';
                closeBtn.style.display = 'none';
                importBloc.classList.remove('is-import');
                fileInput.value = '';
                const img = imgBloc.querySelector('img');
                if (img) img.src = '';
            });
        }
    });
}

// Variable pour éviter la double initialisation
let isInitialized = false;

// Initialisation automatique
document.addEventListener('DOMContentLoaded', function() {
    if (!isInitialized) {
        initArticleImageImport();
        isInitialized = true;
    }
});

// Initialisation également après chargement complet de la page
window.addEventListener('load', function() {
    if (!isInitialized) {
        initArticleImageImport();
        isInitialized = true;
    }
}); 