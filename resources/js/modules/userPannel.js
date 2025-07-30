// Gestion du panneau utilisateur
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner les éléments pour les deux sidebars
    const authTriggerNormal = document.querySelector('.sidebar--left .auth-trigger');
    const authTriggerCondense = document.querySelector('.sidebar--condense .auth-trigger2');
    const userPannelNormal = document.querySelector('.sidebar--left .stack__meta-pannel');
    const userPannelCondense = document.querySelector('.sidebar--condense .stack__meta-pannel');
    
    // Fonction pour gérer le clic sur un trigger
    function handleAuthTriggerClick(e, pannel) {
        e.preventDefault();
        e.stopPropagation();
        
        if (pannel) {
            // Basculer l'affichage du panneau
            if (pannel.style.display === 'none' || pannel.style.display === '') {
                pannel.style.display = 'block';
            } else {
                pannel.style.display = 'none';
            }
        }
    }
    
    // Fonction pour fermer tous les panneaux
    function closeAllPannels() {
        if (userPannelNormal) userPannelNormal.style.display = 'none';
        if (userPannelCondense) userPannelCondense.style.display = 'none';
    }
    
    // Masquer tous les panneaux au chargement
    if (userPannelNormal) userPannelNormal.style.display = 'none';
    if (userPannelCondense) userPannelCondense.style.display = 'none';
    
    // Gérer le clic sur l'avatar de la sidebar normale
    if (authTriggerNormal && userPannelNormal) {
        authTriggerNormal.addEventListener('click', function(e) {
            handleAuthTriggerClick(e, userPannelNormal);
        });
    }
    
    // Gérer le clic sur l'avatar de la sidebar condensée
    if (authTriggerCondense && userPannelCondense) {
        authTriggerCondense.addEventListener('click', function(e) {
            handleAuthTriggerClick(e, userPannelCondense);
        });
    }
    
    // Fermer les panneaux quand on clique ailleurs
    document.addEventListener('click', function(e) {
        const isClickInsidePannel = (userPannelNormal && userPannelNormal.contains(e.target)) || 
                                   (userPannelCondense && userPannelCondense.contains(e.target));
        const isClickOnTrigger = (authTriggerNormal && authTriggerNormal.contains(e.target)) || 
                                (authTriggerCondense && authTriggerCondense.contains(e.target));
        
        if (!isClickInsidePannel && !isClickOnTrigger) {
            closeAllPannels();
        }
    });
    
    // Fermer les panneaux avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllPannels();
        }
    });
    
    // Gérer le redimensionnement de la fenêtre
    window.addEventListener('resize', function() {
        const isTablet = window.innerWidth >= 768 && window.innerWidth <= 1023;
        
        if (isTablet) {
            // En mode tablette, fermer le panneau de la sidebar normale
            if (userPannelNormal) userPannelNormal.style.display = 'none';
        } else {
            // En mode desktop, fermer le panneau de la sidebar condensée
            if (userPannelCondense) userPannelCondense.style.display = 'none';
        }
    });
}); 