// Encapsulation pour éviter la pollution globale
(function() {
    const ALERT__CONTENT = document.querySelector('.alert');
    const ALERT__CLOSE = document.querySelector('.alert__close-btn');

    if (ALERT__CONTENT && ALERT__CLOSE) {
        ALERT__CLOSE.addEventListener('click', function() {
            ALERT__CONTENT.classList.remove('alert--visible');
        });
    }
})();