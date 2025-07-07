// Encapsulation pour éviter la pollution globale
(function() {
    /*const ACTION_REACT__LIKE = document.querySelector('.action-react.post--like');
    const ACTION_REACT__LIKE_ICON = document.querySelector('.action-react.post--like i');
    const ACTION_REACT__SAVED = document.querySelector('.action-react.post--saved');
    const ACTION_REACT__SAVED_ICON = document.querySelector('.action-react.post--saved i');
    const ACTION_REACT__LIKE_P = document.querySelector('.action-react.post--like p');
    const DATA_TITLE_LIKE = document.querySelector('.action-react.post--like');
    const DATA_TITLE_SAVED = document.querySelector('.action-react.post--saved');

    // Gestion du like
    if (ACTION_REACT__LIKE && ACTION_REACT__LIKE_ICON && ACTION_REACT__LIKE_P && DATA_TITLE_LIKE) {
        ACTION_REACT__LIKE.addEventListener('click', function () {
            let nbr_like = ACTION_REACT__LIKE_P.textContent ? ACTION_REACT__LIKE_P.textContent.trim() : "0";
            nbr_like = isNaN(parseInt(nbr_like)) ? 0 : parseInt(nbr_like);

            if (ACTION_REACT__LIKE_ICON.classList.contains('ri-heart-line')) {
                ACTION_REACT__LIKE_ICON.classList.replace('ri-heart-line', 'ri-heart-fill');
                nbr_like++;
                DATA_TITLE_LIKE.dataset.title = 'Disliker';
            } else {
                ACTION_REACT__LIKE_ICON.classList.replace('ri-heart-fill', 'ri-heart-line');
                nbr_like = Math.max(0, nbr_like - 1);
                DATA_TITLE_LIKE.dataset.title = 'Liker';
            }

            ACTION_REACT__LIKE_P.textContent = nbr_like.toString();

            if (nbr_like > 0) {
                ACTION_REACT__LIKE_P.classList.remove('d-none');
            } else {
                ACTION_REACT__LIKE_P.classList.add('d-none');
            }
        });
    }*/

    /*document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const type = this.dataset.type;
            const currentCount = parseInt(this.querySelector('p').textContent) || "0";
            const likeIcon = this.querySelector('i');

            fetch('/like', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id, type })
            })
            .then(res => res.json())
            .then(data => {
                if (data.liked !== undefined) {
                    if (likeIcon.classList.contains('ri-heart-line')) {
                        likeIcon.classList.replace('ri-heart-line', 'ri-heart-fill');
                    } else {
                        likeIcon.classList.replace('ri-heart-fill', 'ri-heart-line');
                    }
                    currentCount.innerHTML = data.count;
                }
            });
        });
    });*/

    // Gestion du bouton "enregistrer"
    /*if (ACTION_REACT__SAVED && ACTION_REACT__SAVED_ICON && DATA_TITLE_SAVED) {
        ACTION_REACT__SAVED.addEventListener('click', function () {
            if (ACTION_REACT__SAVED_ICON.classList.contains('ri-bookmark-line')) {
                ACTION_REACT__SAVED_ICON.classList.replace('ri-bookmark-line', 'ri-bookmark-fill');
                DATA_TITLE_SAVED.dataset.title = "Annuler l'enregistrement";
            } else {
                ACTION_REACT__SAVED_ICON.classList.replace('ri-bookmark-fill', 'ri-bookmark-line');
                DATA_TITLE_SAVED.dataset.title = 'Enregister';
            }
        });
    }*/

    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const type = this.dataset.type;
            const currentCount = parseInt(this.querySelector('p').textContent) || "0";
            const likeIcon = this.querySelector('i');

            fetch('/like', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id, type })
            })
            .then(res => res.json())
            .then(data => {
                if (data.liked !== undefined) {
                    currentCount = data.count;
                }
            });
        });
    });
})();

