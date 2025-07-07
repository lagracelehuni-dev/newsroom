// Encapsulation pour éviter la pollution globale
(function() {
    const HOME_BODY = document.querySelector('.home-body');
    const HOME_BODY__LOADING = document.querySelector('.home-body__loading');

    if (HOME_BODY && HOME_BODY__LOADING) {
        HOME_BODY.addEventListener('scroll', () => {
            if (HOME_BODY.scrollTop + HOME_BODY.clientHeight >= HOME_BODY.scrollHeight) {
                setTimeout(() => {
                    HOME_BODY__LOADING.style.display = 'block';
                }, 1000);
            } else if (HOME_BODY.scrollTop + HOME_BODY.clientHeight < HOME_BODY.scrollHeight - 100) {
                HOME_BODY__LOADING.style.display = 'none';
            }
        });
    }
})();