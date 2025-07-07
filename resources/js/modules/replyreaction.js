// Encapsulation pour éviter la pollution globale
(function() {
    const BTN__LIKE = document.querySelectorAll('.action-react.btn--like');
    const BTN__LIKE_ICON = document.querySelectorAll('.action-react.btn--like i');
    const BTN__LIKE_P = document.querySelectorAll('.action-react.btn--like p');
    const DATA_TITLE_BTNLIKE = document.querySelectorAll('.action-react.btn--like');

    // Vérification de la présence d'au moins un bouton
    if (BTN__LIKE.length && BTN__LIKE_ICON.length && BTN__LIKE_P.length && DATA_TITLE_BTNLIKE.length) {
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.action-react.btn--like');
            if (!btn) return;
            let icon = btn.querySelector('i');
            let countElem = btn.querySelector('p');
            let nbr_like = countElem && countElem.textContent ? countElem.textContent.trim() : "0";
            nbr_like = isNaN(parseInt(nbr_like)) ? 0 : parseInt(nbr_like);

            if (icon && icon.classList.contains('ri-heart-line')) {
                icon.classList.replace('ri-heart-line', 'ri-heart-fill');
                nbr_like++;
                btn.dataset.title = 'Disliker';
            } else if (icon && icon.classList.contains('ri-heart-fill')) {
                icon.classList.replace('ri-heart-fill', 'ri-heart-line');
                nbr_like = Math.max(0, nbr_like - 1);
                btn.dataset.title = 'Liker';
            }
            if (countElem) {
                countElem.textContent = nbr_like.toString();
                if (nbr_like > 0) {
                    countElem.classList.remove('d-none');
                } else {
                    countElem.classList.add('d-none');
                }
            }
        });
    }
})();
// Ce fichier est désormais géré par la délégation d'événements dans like.js
// (voir like.js pour la gestion dynamique des likes)