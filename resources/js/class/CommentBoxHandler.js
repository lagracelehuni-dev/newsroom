// resources/js/class/CommentBoxHandler.js

// Classe pour gérer l'envoi des commentaires et réponses (formulaires)
export default class CommentBoxHandler {
    /**
     * @param {string} formSelector - Sélecteur du formulaire à gérer
     * @param {string} textareaSelector - Sélecteur du textarea à vider après envoi
     * @param {string} blocShowMsgSelector - Sélecteur du bloc où afficher les messages
     * @param {string} commentListSelector - Sélecteur du conteneur de la liste des commentaires
     */
    constructor(formSelector, textareaSelector, blocShowMsgSelector, commentListSelector) {
        console.log('CommentBoxHandler initialisé avec:', { formSelector, textareaSelector, blocShowMsgSelector, commentListSelector });
        this.form = document.querySelector(formSelector);
        this.textarea = document.querySelector(textareaSelector);
        this.blocShowMsg = document.querySelector(blocShowMsgSelector);
        this.commentList = document.querySelector(commentListSelector);
        
        console.log('Éléments trouvés:', {
            form: !!this.form,
            textarea: !!this.textarea,
            blocShowMsg: !!this.blocShowMsg,
            commentList: !!this.commentList
        });
        
        this.init();
    }

    init() {
        if (this.form) {
            console.log('Ajout de l\'écouteur d\'événement sur le formulaire');
            this.form.addEventListener('submit', this.handleSubmit.bind(this));
        } else {
            console.log('Formulaire non trouvé:', this.form);
        }
    }

    // Gère la soumission du formulaire
    handleSubmit(e) {
        console.log('Soumission du formulaire détectée');
        e.preventDefault();

        const formData = new FormData(this.form);
        let msgBox;

        console.log('Envoi de la requête AJAX...');
        fetch(this.form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            console.log('Réponse reçue:', data);
            // Création du bloc message
            const blocShowMsg = document.querySelector('.bloc__show-msg');
            msgBox = document.createElement('p');
            msgBox.className = 'comment-message success';
            msgBox.textContent = data.message || 'Commentaire ajouté avec succès !';

            if (data.success) {
                // Ajout du commentaire à la liste
                if (this.commentList && data.comment_html) {
                    this.commentList.insertAdjacentHTML('afterbegin', data.comment_html);
                }

                // Vidage du textarea
                if (this.textarea) {
                    this.textarea.value = '';
                }

                // Affichage du message de succès
                this.blocShowMsg?.prepend(msgBox);
                setTimeout(() => { msgBox.remove(); }, 3000);

                // Gestion spécifique selon le type de formulaire
                if (this.form.classList.contains('comment-reply')) {
                    // Masquer le formulaire de réponse
                    this.form.style.display = 'none';
                } else if (this.form.classList.contains('comment-box')) {
                    // Réafficher la box principale si elle existe
                    const mainBox = document.querySelector('.comment-box');
                    if (mainBox) {
                        const COMMENT_INPUT = document.querySelector('.comment-box__textarea');
                        mainBox.style.display = 'flex';
                        if (COMMENT_INPUT) COMMENT_INPUT.classList.remove('is-focus');
                        const mainBoxContainer = document.querySelector('.comment-box__container');
                        if (mainBoxContainer) mainBoxContainer.classList.remove('is-active');
                    }
                }
            } else {
                msgBox.textContent = data.message || 'Le champ commentaire ne peut pas être vide.';
                msgBox.classList.add('error');
                this.blocShowMsg?.prepend(msgBox);
                setTimeout(() => { msgBox.remove(); }, 5000);
            }
        })
        .catch(err => {
            console.error('Erreur lors de l\'envoi du commentaire:', err);
            msgBox = document.createElement('p');
            msgBox.className = 'comment-message error';
            msgBox.textContent = 'Une erreur est survenue lors de l\'envoi du commentaire.';
            this.blocShowMsg?.prepend(msgBox);
            setTimeout(() => { msgBox.remove(); }, 5000);
        });
    }
}

document.addEventListener('click', function(e) {
    // Ouvre le panel d'action du commentaire
    if (e.target.closest('.content-pannel--modifier')) {
        e.preventDefault();
        document.querySelectorAll('.comment__content-pannel').forEach(panel => panel.style.display = 'none');
        const commentDiv = e.target.closest('.comment');
        const contentText = commentDiv.querySelector('.comment__content-text');
        const contentP = commentDiv.querySelector('.text__paragraph');
        const originalText = contentP.textContent;

        // Crée un formulaire inline
        const form = document.createElement('form');
        form.className = 'comment-edit-form';
        form.innerHTML = `
            <div class="bloc__textarea">
                <textarea type="text" class="comment-edit__textarea" name="comment">${originalText}</textarea>
            </div>
            <div class="s-stack">
                <button class="btn btn-sm btn-primary" type="submit">Enregistrer</button>
                <button class="btn btn-sm btn-outlined-secondary cancel-edit" type="button">Annuler</button>
            </div>
        `;

        contentText.replaceWith(form);

        form.querySelector('.cancel-edit').onclick = () => {
            form.replaceWith(contentText);
        };

        form.onsubmit = function(ev) {
            ev.preventDefault();
            const formData = new FormData(form);
            fetch('/comments/' + commentDiv.dataset.commentId + '/update', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.comment_html) {
                    // Remplacement du bloc
                    const commentId = commentDiv.dataset.commentId;
                    commentDiv.outerHTML = data.comment_html;
                    // Sélectionne le nouveau bloc inséré
                    const newCommentDiv = document.querySelector('.comment[data-comment-id="' + commentId + '"]');
                    const blocShowMsg = document.querySelector('.bloc__show-msg');
                    // Affiche une notification de succès
                    if (newCommentDiv) {
                        const msgBox = document.createElement('div');
                        msgBox.className = 'comment-message success';
                        msgBox.textContent = 'Commentaire modifié avec succès !';
                        blocShowMsg.prepend(msgBox);
                        setTimeout(() => { msgBox.remove(); }, 2000);
                    }
                    // Réinitialise le clamp et les triggers UNIQUEMENT sur ce bloc si possible
                    if (typeof window.lineClampInit === 'function') {
                        if (newCommentDiv) {
                            try { window.lineClampInit(newCommentDiv); } catch { window.lineClampInit(); }
                        } else {
                            window.lineClampInit();
                        }
                    }
                    if (typeof window.initCommentTriggers === 'function') {
                        if (newCommentDiv) {
                            try { window.initCommentTriggers(newCommentDiv); } catch { window.initCommentTriggers(); }
                        } else {
                            window.initCommentTriggers();
                        }
                    }
                } else {
                    // Affiche un message d'erreur si champ vide ou autre erreur
                    const blocShowMsg = document.querySelector('.bloc__show-msg');
                    const msgBox = document.createElement('div');
                    msgBox.className = 'comment-message error';
                    msgBox.textContent = data.message || 'Le champ commentaire ne peut pas être vide.';
                    blocShowMsg.prepend(msgBox);
                    setTimeout(() => { msgBox.remove(); }, 4000);
                }
            });
        };
    }

    // Suppression d'un commentaire
    if (e.target.closest('.content-pannel--delete')) {
        e.preventDefault();
        const commentDiv = e.target.closest('.comment');
        if (!commentDiv) return;
        // Utilisation de confirmAction pour la suppression
        confirmAction('Voulez-vous vraiment supprimer ce commentaire ?', () => {
            fetch('/comments/' + commentDiv.dataset.commentId + '/delete', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            })
            .then(res => res.json())
            .then(data => {
                const blocShowMsg = document.querySelector('.bloc__show-msg');
                const msgBox = document.createElement('div');
                if (data.success) {
                    commentDiv.remove();
                    msgBox.className = 'comment-message success';
                    msgBox.textContent = 'Commentaire supprimé avec succès !';
                } else {
                    msgBox.className = 'comment-message error';
                    msgBox.textContent = data.message || 'Erreur lors de la suppression du commentaire.';
                }
                blocShowMsg.prepend(msgBox);
                setTimeout(() => { msgBox.remove(); }, 2500);
            })
            .catch(() => {
                const blocShowMsg = document.querySelector('.bloc__show-msg');
                const msgBox = document.createElement('div');
                msgBox.className = 'comment-message error';
                msgBox.textContent = 'Erreur lors de la suppression du commentaire.';
                blocShowMsg.prepend(msgBox);
                setTimeout(() => { msgBox.remove(); }, 2500);
            });
        });
    }
});

// Fonction confirmAction réutilisable
function confirmAction(message, onConfirm) {
    const blocConfirmAction = document.querySelector('.bloc__confirm-action') || document.body;
    const confirmActionHTML = `
            <p class="text__confirm-action">${message}</p>
            <div class="stack__confirm-action">
                <button type="button" class="btn-sm btn__delete">Supprimer</button>
                <button type="button" class="btn-sm btn__annuler">Annuler</button>
            </div>`;
    const modal = document.createElement('div');
    modal.className = 'confirm-action';
    modal.innerHTML = confirmActionHTML;
    blocConfirmAction.append(modal);

    modal.querySelector('.btn__annuler').onclick = () => {
        modal.remove();
    };
    modal.querySelector('.btn__delete').onclick = () => {
        modal.remove();
        if (typeof onConfirm === 'function') onConfirm();
    };
}

function escapeHTML(str) {
    return str.replace(/[&<>"']/g, function(m) {
        return ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        })[m];
    });
}
