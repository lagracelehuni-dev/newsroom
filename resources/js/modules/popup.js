// Toute la logique de popups est désormais gérée par la délégation d'événements ci-dessous
// Plus besoin d'attacher des listeners sur les éléments statiques
// Voir la délégation d'événements plus bas dans ce fichier

// Encapsulation pour éviter la pollution globale
(function() {
    // Récupérer les éléments du DOM
    const POPUP__WELCOME = document.querySelector('.popup--welcome') // Le pop-up
    const POPUP__ALERT = document.querySelector('.popup--alert') // Le pop-up
    const POPUP__CONGRATS = document.querySelector('.popup--congrats') // Le pop-up

    const POPUP_TRIGGER = document.querySelectorAll('.popup-trigger') // Le bouton pour ouvrir le pop-up
    const CLOSE_BUTTON__WELCOME = document.querySelector('.popup--welcome .popup__close') // Le bouton pour fermer le pop-up
    const CLOSE_BUTTON__ALERT = document.querySelector('.popup--alert .popup__close') // Le bouton pour fermer le pop-up
    const CLOSE_BUTTON__CONGRATS = document.querySelector('.popup--congrats .popup__close') // Le bouton pour fermer le pop-up


    // Pop-up de bienvenue
    if (POPUP__WELCOME && CLOSE_BUTTON__WELCOME) {
        setTimeout(() => {
            POPUP__WELCOME.classList.add('popup--visible')
        }, 800)

        //Fermer le pop-up
        CLOSE_BUTTON__WELCOME.addEventListener('click', function() {
            POPUP__WELCOME.classList.remove('popup--visible')
            if (POPUP__ALERT) POPUP__ALERT.style.display = "none"

            // Appel AJAX sécurisé (à adapter côté backend pour le token)
            fetch('/mark-visited', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                }
            })
        })
    }

    // Pop-up d'alerte
    if (POPUP__ALERT && CLOSE_BUTTON__ALERT) {
        POPUP_TRIGGER.forEach( trigger => {
            trigger.addEventListener('click', function() {
                POPUP__ALERT.style.display = "flex"
            })
        })
        
        CLOSE_BUTTON__ALERT.addEventListener('click', function() {
            POPUP__ALERT.style.display = "none"
        })
    }

    // Pop-up de félicitations
    if (POPUP__CONGRATS && CLOSE_BUTTON__CONGRATS) {
        // Après 3000ms le pop-up devient visible automatiquement
        setTimeout(() => {
            POPUP__CONGRATS.classList.add('popup--visible')
        }, 300)

        CLOSE_BUTTON__CONGRATS.addEventListener('click', function() {
            POPUP__CONGRATS.classList.remove('popup--visible')
        })
    }

    document.addEventListener('click', function(e) {
        // Popup trigger
        if (e.target.closest('.popup-trigger')) {
            const POPUP__ALERT = document.querySelector('.popup--alert');
            if (POPUP__ALERT) POPUP__ALERT.style.display = "flex";
            return;
        }
        // Popup close (welcome)
        if (e.target.closest('.popup--welcome .popup__close')) {
            const POPUP__WELCOME = document.querySelector('.popup--welcome');
            if (POPUP__WELCOME) POPUP__WELCOME.classList.remove('popup--visible');
            const POPUP__ALERT = document.querySelector('.popup--alert');
            if (POPUP__ALERT) POPUP__ALERT.style.display = "none";
            fetch('/mark-visited', {
                method: 'POST',
                headers: { 'Accept': 'application/json' }
            });
            return;
        }
        // Popup close (alert)
        if (e.target.closest('.popup--alert .popup__close')) {
            const POPUP__ALERT = document.querySelector('.popup--alert');
            if (POPUP__ALERT) POPUP__ALERT.style.display = "none";
            return;
        }
        // Popup close (congrats)
        if (e.target.closest('.popup--congrats .popup__close')) {
            const POPUP__CONGRATS = document.querySelector('.popup--congrats');
            if (POPUP__CONGRATS) POPUP__CONGRATS.style.display = "none";
            return;
        }
    });
})();