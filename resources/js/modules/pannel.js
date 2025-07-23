// Encapsulation pour éviter la pollution globale
(function() {
    const STACK_META_MORE = document.querySelectorAll('.auth-trigger');
    const STACK_META_PANNEL = document.querySelector('.stack__meta-pannel');

    if (STACK_META_MORE.length) {
        STACK_META_MORE.forEach(function(item) {
            item.addEventListener('click', function() {
                STACK_META_PANNEL.style.display = "block";
            });
        });

        window.addEventListener('click', function(event) {
            if (!event.target.closest('.stack__meta-pannel') && 
                !event.target.closest('.auth-trigger') &&
                !event.target.closest('.stack__meta-content--condense.auth-trigger')) {
                STACK_META_PANNEL.style.display = "none";
            }
        });
    }
})();