import Trigger from './class/Trigger.js';

(function() {
    const TRIGGER_SEARCH = document.querySelector('.trigger-search');
    const TRIGGER_SIDEBAR = document.querySelector('.trigger-sidebar');
    const TRIGGER_HIDDE = document.querySelectorAll('.trigger-hidde');
    const CLOSE_SEARCH = document.querySelector('.sidebar__close');
    const CLOSE_SIDEBAR = document.querySelector('.pannel-auth__close');

    const BLOC_SEARCH = document.querySelector('.sidebar--right');
    const BLOC_SIDEBAR = document.querySelector('.pannel-auth');

    // Déclare les variables en local avec let pour éviter l'erreur de portée
    let triggerSearch = new Trigger(TRIGGER_SEARCH, CLOSE_SEARCH, BLOC_SEARCH);
    let triggerSidebar = new Trigger(TRIGGER_SIDEBAR, CLOSE_SIDEBAR, BLOC_SIDEBAR);
    triggerSearch.show();
    triggerSearch.hidden(TRIGGER_HIDDE);
    triggerSidebar.show();
    triggerSidebar.hidden(TRIGGER_HIDDE);
})()
