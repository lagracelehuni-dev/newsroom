// Encapsulation pour éviter la pollution globale
(function() {
    const NAV_LINKS = document.querySelectorAll('.nav-link');
    const TRIGGER_BACK = document.querySelectorAll('.trigger-back');
    const TRIGGER_OPEN = document.querySelectorAll('.trigger-open')
    const TRIGGER_OPEN_SD = document.querySelector('.trigger-open-sd')
    const TRIGGER_CLOSE = document.querySelectorAll('.trigger-close')
    const BLOC_MODAL__LOGOUT = document.querySelector('.bloc__modal.bloc--modal-logout')
    const BLOC_MODAL__DELETE_ACCOUNT = document.querySelector('.bloc__modal.bloc--modal-delete-account')

    if (NAV_LINKS.length) {
        NAV_LINKS.forEach(nav => {
            const NAV_LINKS_ICONS = nav.querySelector('i');
            const ICON_LINE = nav.getAttribute('data-icon');
            const ICON_FILL = nav.getAttribute('data-icon-fill');

            if (nav.classList.contains('is-active')) {
                NAV_LINKS_ICONS.classList.replace(`ri-${ICON_LINE}`, `ri-${ICON_FILL}`);
            }

            nav.addEventListener('mouseover', () => {
                NAV_LINKS_ICONS.classList.replace(`ri-${ICON_LINE}`, `ri-${ICON_FILL}`);
            });

            nav.addEventListener('mouseout', () => {
                if (!nav.classList.contains('is-active'))
                    NAV_LINKS_ICONS.classList.replace(`ri-${ICON_FILL}`, `ri-${ICON_LINE}`);
            });

            // nav.addEventListener('click', () => {
            //     NAV_LINKS.forEach(t => {
            //         t.classList.remove('is-active');
            //         t.querySelector('i').classList.replace(`ri-${t.getAttribute('data-icon-fill')}`, `ri-${t.getAttribute('data-icon')}`);
            //     });
            //     nav.classList.add('is-active');
            //     NAV_LINKS_ICONS.classList.replace(`ri-${ICON_LINE}`, `ri-${ICON_FILL}`);
            // });
        });
    }

    if (TRIGGER_BACK.length) {

        TRIGGER_BACK.forEach((trigger) => {
            trigger.addEventListener('click', function() {
                history.back();
            })
        });
    }

    // Fonction utilitaire pour tout masquer
    function hideModals() {
        BLOC_MODAL__LOGOUT.style.display = 'none';
        BLOC_MODAL__DELETE_ACCOUNT.style.display = 'none';
    }

    // Gestion des déclencheurs d'ouverture
    if (TRIGGER_OPEN.length) {
        TRIGGER_OPEN.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                BLOC_MODAL__LOGOUT.style.display = 'flex';
            });
        });
    }

    if (TRIGGER_OPEN_SD) {
        TRIGGER_OPEN_SD.addEventListener('click', () => {
            BLOC_MODAL__DELETE_ACCOUNT.style.display = 'flex';
        })
    }

    // Gestion des déclencheurs de fermeture
    if (TRIGGER_CLOSE.length) {
        TRIGGER_CLOSE.forEach((trigger) => {
            trigger.addEventListener('click', hideModals);
        });
    }
})();



