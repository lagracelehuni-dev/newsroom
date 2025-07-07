(function() {
    // Récupère les éléments du DOM
    const filterButton = document.querySelector('.category__button');
    const filterContent = document.querySelector('.category__content');
    const options = document.querySelectorAll('.category__content .compose__item');

    // Vérifie l'existence des éléments essentiels
    if (!filterButton || !filterContent) return;

    document.addEventListener('click', function(e) {
        // Ouvre/ferme le menu déroulant
        if (e.target.closest('.category__button')) {
            const filterButton = document.querySelector('.category__button');
            const filterContent = document.querySelector('.category__content');
            if (filterButton && filterContent) {
                filterContent.style.display = 'flex';
                filterButton.classList.add('open');
            }
            return;
        }
        // Sélection d'une option
        if (e.target.closest('.category__content .compose__item')) {
            const option = e.target.closest('.category__content .compose__item');
            const filterButton = document.querySelector('.category__button');
            const filterContent = document.querySelector('.category__content');
            if (filterButton && filterContent && option) {
                const label = filterButton.querySelector('span') || filterButton.childNodes[0];
                if (label) label.textContent = option.textContent;
                filterContent.style.display = 'none';
                filterButton.classList.add('is-active');
                filterButton.classList.remove('open');
            }
            return;
        }
        // Ferme le menu si clic en dehors
        if (!e.target.closest('.category__button') && !e.target.closest('.category__content')) {
            const filterButton = document.querySelector('.category__button');
            const filterContent = document.querySelector('.category__content');
            if (filterButton && filterContent) {
                filterContent.style.display = 'none';
                filterButton.classList.remove('open');
            }
        }
    });
})();