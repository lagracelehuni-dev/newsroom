// Encapsulation pour éviter la pollution globale
(function() {
    document.addEventListener('click', function(e) {
        // Lightbox trigger
        const trigger = e.target.closest('.lightbox-trigger');
        if (trigger) {
            const LIGHT_BOX_CONTENT = document.querySelector('.lightbox');
            const LIGHT_BOX_IMG = document.querySelector('.lightbox__image');
            const IMG = trigger.getAttribute('data-img');
            // Cherche l'image dans le même commentaire que le trigger
            let imgInComment = trigger.closest('.comment__content-img')?.querySelector('img');
            if (LIGHT_BOX_CONTENT && LIGHT_BOX_IMG) {
                LIGHT_BOX_CONTENT.style.display = "flex";
                LIGHT_BOX_IMG.src = IMG || (imgInComment ? imgInComment.src : '');
            }
            return;
        }
        // Lightbox close
        if (e.target.closest('.lightbox__close')) {
            const LIGHT_BOX_CONTENT = document.querySelector('.lightbox');
            if (LIGHT_BOX_CONTENT) LIGHT_BOX_CONTENT.style.display = "none";
        }
    });
})();