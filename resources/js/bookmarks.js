document.querySelectorAll('.bookmark-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
        const postId = this.dataset.id;
        fetch(`/bookmarks/${postId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            const blocShowMsg = document.querySelector('.bloc__show-msg');
            const msgBox = document.createElement('div');
            const icon = this.querySelector('i');
            icon.className = data.bookmarked ? 'ri-bookmark-fill' : 'ri-bookmark-line';
            if (data.success) {
                msgBox.className = 'comment-message info';
                msgBox.textContent = data.message;
            }
            else {
                msgBox.className = 'comment-message error';
                msgBox.textContent = data.message || 'Une erreur est survenue.';
            }
            blocShowMsg.prepend(msgBox);
            setTimeout(() => { msgBox.remove(); }, 2500);
        });
    });
});
// End of file: resources/js/bookmarks.js
