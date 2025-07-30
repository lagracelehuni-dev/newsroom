(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.querySelector('.avatar-import__input');
        const avatarPreview = document.querySelector('.avatar-import__preview');
        const avatarBrowseBtn = document.querySelector('.avatar-import__browse');
        const avatarCloseBtn = document.querySelector('.avatar-import__close');

        if (!avatarInput || !avatarPreview || !avatarBrowseBtn) return;

        // Gestion du clic sur le bouton de parcours
        avatarBrowseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            avatarInput.click();
        });

        // Gestion de la sélection de fichier
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validation pour accepter uniquement JPEG et JPG
                const allowedTypes = ['image/jpeg', 'image/jpg'];
                const fileExtension = file.name.toLowerCase().split('.').pop();
                const allowedExtensions = ['jpg', 'jpeg'];

                if (allowedTypes.includes(file.type) || allowedExtensions.includes(fileExtension)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = avatarPreview.querySelector('img');
                        if (img) {
                            img.src = e.target.result;
                        } else {
                            avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Aperçu de l'avatar">`;
                        }
                        avatarPreview.style.display = 'block';
                        if (avatarCloseBtn) avatarCloseBtn.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Veuillez sélectionner une image au format JPEG ou JPG uniquement.');
                    avatarInput.value = '';
                }
            }
        });

        // Gestion de la fermeture de l'aperçu
        if (avatarCloseBtn) {
            avatarCloseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                avatarPreview.style.display = 'none';
                avatarCloseBtn.style.display = 'none';
                avatarInput.value = '';
                const img = avatarPreview.querySelector('img');
                if (img) img.src = '';
            });
        }
    });
})();
