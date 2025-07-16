// Fonction utilitaire pour initialiser l'import d'image sur un parent donné (ou document par défaut)
export function initImageImport(parent = document) {
  parent.querySelectorAll('.image-import').forEach(importBloc => {
    const fileInput = importBloc.querySelector('.image-import__input');
    const imgBloc = importBloc.querySelector('.image-import__preview');
    const closeBtn = importBloc.querySelector('.image-import__close');
    const browseBtn = importBloc.querySelector('.image-import__browse');
    const img = imgBloc ? imgBloc.querySelector('img') : null;
    const commentBoxContainer = document.querySelector('.comment-box__container');

    // Bouton parcourir
    if (browseBtn && fileInput && !browseBtn.dataset.imageImportInit) {
      browseBtn.addEventListener('click', function () {
        fileInput.click();
      });
      browseBtn.dataset.imageImportInit = '1';
    }

    // Changement de fichier
    if (fileInput && img && imgBloc && closeBtn && !fileInput.dataset.imageImportInit) {
      fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
          alert('Seules les images sont autorisées.');
          this.value = '';
          return;
        }
        // Optionnel : à adapter selon le contexte d'utilisation
        if (typeof commentBoxContainer !== 'undefined' && commentBoxContainer) commentBoxContainer.classList.add('is-active');
        img.src = URL.createObjectURL(file);
        imgBloc.style.display = 'flex';
        closeBtn.style.display = 'flex';
        importBloc.classList.add('is-import');
      });
      fileInput.dataset.imageImportInit = '1';
    }

    // Fermeture de l'image importée
    if (closeBtn && img && fileInput && !closeBtn.dataset.imageImportInit) {
      closeBtn.addEventListener('click', function () {
        imgBloc.style.display = 'none';
        closeBtn.style.display = 'none';
        importBloc.classList.remove('is-import');
        img.src = '';
        // Optionnel : à adapter selon le contexte d'utilisation
        if (typeof commentBoxContainer !== 'undefined' && commentBoxContainer) commentBoxContainer.classList.remove('is-active');
        fileInput.value = '';
      });
      closeBtn.dataset.imageImportInit = '1';
    }
  });
}

// Initialisation automatique sur tout le document pour l'import d'image dynamique
window.initImageImport = function(parent = document) {
  parent.querySelectorAll('.image-import').forEach(importBloc => {
    const fileInput = importBloc.querySelector('.image-import__input');
    const imgBloc = importBloc.querySelector('.image-import__preview');
    const closeBtn = importBloc.querySelector('.image-import__close');
    const browseBtn = importBloc.querySelector('.image-import__browse');
    const img = imgBloc ? imgBloc.querySelector('img') : null;
    const commentBoxContainer = document.querySelector('.comment-box__container');

    // Bouton parcourir
    if (browseBtn && fileInput && !browseBtn.dataset.imageImportInit) {
      browseBtn.addEventListener('click', function () {
        fileInput.click();
      });
      browseBtn.dataset.imageImportInit = '1';
    }

    // Changement de fichier
    if (fileInput && img && imgBloc && closeBtn && !fileInput.dataset.imageImportInit) {
      fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
          alert('Seules les images sont autorisées.');
          this.value = '';
          return;
        }
        if (typeof commentBoxContainer !== 'undefined' && commentBoxContainer) commentBoxContainer.classList.add('is-active');
        img.src = URL.createObjectURL(file);
        imgBloc.style.display = 'flex';
        closeBtn.style.display = 'flex';
        importBloc.classList.add('is-import');
      });
      fileInput.dataset.imageImportInit = '1';
    }

    // Fermeture de l'image importée
    if (closeBtn && img && fileInput && !closeBtn.dataset.imageImportInit) {
      closeBtn.addEventListener('click', function () {
        imgBloc.style.display = 'none';
        closeBtn.style.display = 'none';
        importBloc.classList.remove('is-import');
        img.src = '';
        if (typeof commentBoxContainer !== 'undefined' && commentBoxContainer) commentBoxContainer.classList.remove('is-active');
        fileInput.value = '';
      });
      closeBtn.dataset.imageImportInit = '1';
    }
  });
};
// Initialisation automatique au chargement
window.initImageImport();
