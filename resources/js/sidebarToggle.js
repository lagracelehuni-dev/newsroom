// Script pour gérer le toggle de la sidebar gauche (rétractable en tablette)
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebarRight');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('is-active');
            // Optionnel : changer l'icône selon l'état
            const icon = toggleBtn.querySelector('i');
            if (sidebar.classList.contains('is-active')) {
                icon.classList.remove('ri-arrow-left-s-line');
                icon.classList.add('ri-arrow-right-s-line');
            } else {
                icon.classList.remove('ri-arrow-right-s-line');
                icon.classList.add('ri-arrow-left-s-line');
            }
        });
    }
}); 