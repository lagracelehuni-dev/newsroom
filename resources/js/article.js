document.addEventListener('DOMContentLoaded', function () {
    // Gestion du bouton "Afficher plus d’articles"
    const articleList = document.querySelector('.home__body .article-list');
    const loadMoreBtn = document.querySelector('.btn-loadmore--home');
    let textContentBtn = "Afficher plus d’articles <i class='ri ri-arrow-right-s-line'></i>";
    let loading = false;
    let hasMore = true;
    let currentPage = 1;

    if (loadMoreBtn && articleList) {
        loadMoreBtn.addEventListener('click', function() {
            if (loading || !hasMore) return;
            loading = true;
            loadMoreBtn.textContent = 'Chargement...';
            loadMoreBtn.disabled = true;
            const nextPage = currentPage + 1;
            setTimeout(() => {
                fetch(`/articles/load-more?page=${nextPage}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.html) {
                            articleList.insertAdjacentHTML('beforeend', data.html);
                            currentPage = nextPage;
                        }
                        hasMore = data.hasMore;
                        loading = false;
                        loadMoreBtn.innerHTML = textContentBtn;
                        loadMoreBtn.disabled = false;
                        if (!hasMore) loadMoreBtn.style.display = 'none';
                    })
                    .catch(() => {
                        loading = false;
                        loadMoreBtn.textContent = textContentBtn;
                        loadMoreBtn.disabled = false;
                    });
            }, 800);
        });
    }
});

// Affichage de la confirmation de suppression d'article
function confirmAction(message, recupId) {
    const blocConfirmAction = document.querySelector('.bloc__confirm-action');
    // Nettoyer les anciennes confirmations
    blocConfirmAction.innerHTML = '';
    const confirmActionHTML = `
        <div class="confirm-action">
            <p class="text__confirm-action">${message}</p>
            <div class="stack__confirm-action">
                <button type="submit" class="btn-sm btn__delete">Supprimer</button>
                <button type="button" class="btn-sm btn__annuler">Annuler</button>
            </div>
        </div>`;
    blocConfirmAction.innerHTML = confirmActionHTML;

    // Annuler
    blocConfirmAction.querySelector('.btn__annuler').onclick = () => {
        blocConfirmAction.innerHTML = '';
    };
    // Supprimer
    blocConfirmAction.querySelector('.btn__delete').onclick = () => {
        const articleId = recupId.dataset.articleId;
        const formDelete = document.createElement('form');
        formDelete.method = 'GET';
        formDelete.action = `/posts/${articleId}/delete`;
        // Spoofing POST (car la route attend POST)
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        formDelete.appendChild(csrfInput);
        document.body.appendChild(formDelete);
        formDelete.submit();
    };
}

const btnDeleteArticle = document.querySelector('.article__viewprofile-pannel .content-pannel--delete');
if (btnDeleteArticle) {
    btnDeleteArticle.addEventListener('click', function() {
        confirmAction('Voulez-vous vraiment supprimer cet article ?', btnDeleteArticle);
    });
}

// Copy link
document.addEventListener('click', function (e) {
    const target = e.target.closest('.btn-copy-link');
    if (!target) return;

    const urlToCopy = target.dataset.url;
    if (!urlToCopy) return;

    navigator.clipboard.writeText(urlToCopy).then(() => {
        // Animation ou feedback visuel
        target.classList.add('copied');
        target.dataset.title = 'Lien copié !';

        // Retour à l'état initial après 2 secondes
        setTimeout(() => {
            target.dataset.title = 'Copier le lien';
            target.classList.remove('copied');
        }, 2000);
    }).catch(err => {
        console.error('Erreur lors de la copie :', err);
    });
});


