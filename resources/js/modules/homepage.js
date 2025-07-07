// Encapsulation pour éviter la pollution globale
(function() {
    const NAV_LINKS = document.querySelectorAll('.nav-link');
    const TRIGGER_BACK = document.querySelectorAll('.trigger-back');

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
})();



