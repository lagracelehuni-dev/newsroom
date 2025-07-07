document.addEventListener('click', function(e) {
    // Pour les boutons like classiques
    const btn = e.target.closest('.like-btn');
    if (btn) {
        const id = btn.dataset.id;
        const type = btn.dataset.type;
        let countElem = btn.querySelector('p');
        let likeIcon = btn.querySelector('i');

        fetch('/like', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, type })
        })
        .then(res => res.json())
        .then(data => {
            if (data.liked !== undefined) {
                // Met à jour le compteur
                if (countElem) {
                    countElem.textContent = data.count !== 0 ? data.count : '';
                }
                // Met à jour l'icône
                if (likeIcon) {
                    likeIcon.classList.remove('ri-heart-fill', 'ri-heart-line');
                    likeIcon.classList.add(data.liked ? 'ri-heart-fill' : 'ri-heart-line');
                }
            }
        });
        return;
    }
    // Pour les boutons like de replyreaction
    const btnReact = e.target.closest('.action-react.btn--like');
    if (btnReact) {
        let icon = btnReact.querySelector('i');
        let countElem = btnReact.querySelector('p');
        let nbr_like = countElem && countElem.textContent ? countElem.textContent.trim() : "0";
        nbr_like = isNaN(parseInt(nbr_like)) ? 0 : parseInt(nbr_like);

        if (icon && icon.classList.contains('ri-heart-line')) {
            icon.classList.replace('ri-heart-line', 'ri-heart-fill');
            nbr_like++;
            btnReact.dataset.title = 'Disliker';
        } else if (icon && icon.classList.contains('ri-heart-fill')) {
            icon.classList.replace('ri-heart-fill', 'ri-heart-line');
            nbr_like = Math.max(0, nbr_like - 1);
            btnReact.dataset.title = 'Liker';
        }
        if (countElem) {
            countElem.textContent = nbr_like.toString();
            if (nbr_like > 0) {
                countElem.classList.remove('d-none');
            } else {
                countElem.classList.add('d-none');
            }
        }
    }
});
