// Encapsulation pour éviter la pollution globale
window.lineClampInit = function() {
    const blocks = document.querySelectorAll('.comment__content-text');
    console.log('[lineClampInit] blocs trouvés :', blocks.length);
    blocks.forEach(block => {
        const paragraph = block.querySelector('.text__paragraph');
        const seeMoreBtn = block.querySelector('.btn-text--seemore');
        const showLessBtn = block.querySelector('.btn-text--showless');
        if (!paragraph || !seeMoreBtn || !showLessBtn) return;
        paragraph.classList.remove('text--visible');
        const lineHeight = parseFloat(getComputedStyle(paragraph).lineHeight);
        const computedLineHeight = isNaN(lineHeight) ? 1.2 * parseFloat(getComputedStyle(paragraph).fontSize) : lineHeight;
        const maxHeight = 6 * computedLineHeight;
        if (paragraph.scrollHeight - 1 > maxHeight) {
            seeMoreBtn.style.display = 'flex';
            showLessBtn.style.display = 'none';
        } else {
            seeMoreBtn.style.display = 'none';
            showLessBtn.style.display = 'none';
        }
        // Gestion des clics
        seeMoreBtn.onclick = null;
        seeMoreBtn.addEventListener('click', function() {
            paragraph.classList.add('text--visible');
            showLessBtn.style.display = 'flex';
            seeMoreBtn.style.display = 'none';
        });
        showLessBtn.onclick = null;
        showLessBtn.addEventListener('click', function() {
            paragraph.classList.remove('text--visible');
            seeMoreBtn.style.display = 'flex';
            showLessBtn.style.display = 'none';
        });
    });
};
// Initialisation au chargement initial
window.lineClampInit();

