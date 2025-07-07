// Encapsulation pour éviter la pollution globale
(function() {
    const STACK_META_MORE = document.querySelector('.auth-trigger');
    const STACK_META_PANNEL = document.querySelector('.stack__meta-pannel');

    if (STACK_META_MORE && STACK_META_PANNEL) {
        STACK_META_MORE.addEventListener('click', function() {
            STACK_META_PANNEL.style.display = "block";
        });

        window.addEventListener('click', function(event) {
            if (!event.target.closest('.stack__meta-pannel') && 
                !event.target.closest('.auth-trigger')) {
                STACK_META_PANNEL.style.display = "none";
            }
        });
    }
})();