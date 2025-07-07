import CommentBoxHandler from './class/CommentBoxHandler';

// Initialisation pour la box principale
new CommentBoxHandler('.comment-box', '.comment-box__textarea', '.bloc__show-msg', '.comment-list');
// Initialisation pour la box de réponse
new CommentBoxHandler('.comment-reply', '.comment-reply__textarea', '.bloc__show-msg', '.reply__reply-list');

let loading = false;
let hasMore = true;
const commentList = document.querySelector('.comment-list');
const postId = document.querySelector('input[name="post_id"]')?.value;

function getCurrentPage() {
    return parseInt(commentList?.dataset.page || '1', 10);
}

function setCurrentPage(page) {
    if (commentList) commentList.dataset.page = page;
}

function bindLoadMoreButton() {
    const loadMoreBtn = document.querySelector('.btn-loadmore--comment');
    if (!loadMoreBtn) return;
    let textContentBtn = "Afficher plus de commentaires <i class='ri ri-arrow-right-s-line'></i>";
    loadMoreBtn.onclick = null;
    loadMoreBtn.addEventListener('click', function() {
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Chargement...';
        loadMoreComments(() => {
            loadMoreBtn.disabled = false;
            loadMoreBtn.innerHTML = textContentBtn;
            if (!hasMore && loadMoreBtn) loadMoreBtn.style.display = 'none';
        });
    });
}

if (commentList) {
    bindLoadMoreButton();
}

function loadMoreComments(callback) {
    if (loading || !hasMore) return;
    loading = true;
    const nextPage = getCurrentPage() + 1;
    setTimeout(() => {
        fetch(`/comments/load-more?post_id=${postId}&page=${nextPage}`)
            .then(res => res.json())
            .then(data => {
                if (data.html) {
                    commentList.insertAdjacentHTML('beforeend', data.html);
                    setCurrentPage(nextPage);
                    bindLoadMoreButton();
                    if (typeof window.lineClampInit === 'function') window.lineClampInit();
                }
                hasMore = data.hasMore;
                loading = false;
                if (!hasMore && document.querySelector('.btn-loadmore--comment')) {
                    document.querySelector('.btn-loadmore--comment').style.display = 'none';
                }
                if (typeof callback === 'function') callback();
            })
            .catch(() => {
                loading = false;
                if (typeof callback === 'function') callback();
            });
    }, 800);
}
