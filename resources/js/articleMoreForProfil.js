document.addEventListener('DOMContentLoaded', function () {
    const articleList = document.querySelector('.profil__user-articles .article-list'); // adapte le sélecteur à ta liste
    const loadMoreBtn = document.querySelector('.profil__user-articles .btn-loadmore--home'); // adapte le sélecteur à ton bouton
    // const loader = document.querySelector('.home__loading');
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
                // Remplace {username} par la vraie valeur JS
                const username = loadMoreBtn.dataset.username;
                fetch(`/articles/load-more/${username}?page=${nextPage}`) // adapte l’URL à ta route backend
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
            }, 800); // délai pour le loader
        });
    }
});
