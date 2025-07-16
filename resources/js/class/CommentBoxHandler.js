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
        // Sélection des éléments du DOM
        this.form = document.querySelector(formSelector);
        this.textareaSelector = textareaSelector;
        this.blocShowMsg = document.querySelector(blocShowMsgSelector);
        this.commentList = document.querySelector(commentListSelector);
        this.init();
    }

    // Initialise l'écouteur d'événement sur le formulaire
    init() {
        if (!this.form) return;
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    // Gère la soumission du formulaire
    handleSubmit(e) {
        e.preventDefault();
        // Nettoyer les anciens messages d'alerte
        let msgBox = this.blocShowMsg?.querySelector('.comment-message');
        if (msgBox) msgBox.remove();

        const formData = new FormData(this.form);
        const url = this.form.action;
        const commentListEl = this.commentList;

        // Envoi AJAX du formulaire
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            // Création du bloc message
            msgBox = document.createElement('div');
            msgBox.className = 'comment-message';
            if (data.success && data.comment_html) {
                if (commentListEl) {
                    commentListEl.insertAdjacentHTML('afterbegin', data.comment_html);
                    if (typeof window.lineClampInit === 'function') window.lineClampInit();
                    // Réinitialiser les triggers JS sur les nouveaux commentaires
                    if (typeof window.initCommentTriggers === 'function') {
                        window.initCommentTriggers();
                    }
                }
                // Vide le textarea
                this.form.querySelector(this.textareaSelector).value = '';
                // (Optionnel) Réinitialise l'import d'image si présent
                const imgPreview = this.form.querySelector('.comment__import-img');
                if (imgPreview) imgPreview.src = '';
                msgBox.textContent = 'Commentaire envoyé avec succès !';
                msgBox.classList.add('success');
                this.blocShowMsg?.prepend(msgBox);
                setTimeout(() => { msgBox.remove(); }, 2000);
                // Fermer la box de commentaire si c'est une box de réponse
                if (this.form.classList.contains('comment-reply')) {
                    this.form.classList.remove('is-visible');
                    // Réafficher la box principale si elle existe
                    const mainBox = document.querySelector('.comment-box');
                    if (mainBox) {
                        mainBox.style.display = 'flex';
                        const mainBoxContainer = document.querySelector('.comment-box__container');
                        if (mainBoxContainer) mainBoxContainer.classList.remove('is-active');

                        document.querySelectorAll('.image-import').forEach(importBloc => {
                            const fileInput = importBloc.querySelector('.image-import__input');
                            const imgBloc = importBloc.querySelector('.image-import__preview');
                            const closeBtn = importBloc.querySelector('.image-import__close');
                            const img = imgBloc ? imgBloc.querySelector('img') : null;
                        
                            // Fermeture de l'image importée
                            if (closeBtn && img && fileInput) {
                                imgBloc.style.display = 'none';
                                closeBtn.style.display = 'none';
                                importBloc.classList.remove('is-import');
                                img.src = '';
                                fileInput.value = '';
                            }
                        });
                    }
                } else if (this.form.classList.contains('comment-box')) {
                    // Réafficher la box principale si elle existe
                    const mainBox = document.querySelector('.comment-box');
                    if (mainBox) {
                        const COMMENT_INPUT = document.querySelector('.comment-box__textarea');
                        mainBox.style.display = 'flex';
                        if (COMMENT_INPUT) COMMENT_INPUT.classList.remove('is-focus');
                        const mainBoxContainer = document.querySelector('.comment-box__container');
                        if (mainBoxContainer) mainBoxContainer.classList.remove('is-active');
                        document.querySelectorAll('.image-import').forEach(importBloc => {
                            const fileInput = importBloc.querySelector('.image-import__input');
                            const imgBloc = importBloc.querySelector('.image-import__preview');
                            const closeBtn = importBloc.querySelector('.image-import__close');
                            const img = imgBloc ? imgBloc.querySelector('img') : null;
                        
                            // Fermeture de l'image importée
                            if (closeBtn && img && fileInput) {
                                imgBloc.style.display = 'none';
                                closeBtn.style.display = 'none';
                                importBloc.classList.remove('is-import');
                                img.src = '';
                                fileInput.value = '';
                            }
                        });
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
            msgBox = document.createElement('div');
            msgBox.className = 'comment-message error';
            msgBox.textContent = 'Le champ commentaire ne peut pas être vide. Veuillez réessayer.';
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
        const contentImg = commentDiv.querySelector('.comment__content-img img')
        const originalText = contentP.textContent;
        const imgSrc = contentImg?.src ?? "Pas d'image";
        const extraClass = "comment-edit__import"
        const inputClass = "comment-edit__import-input"
        const previewClass = "comment-edit__import-img"
        const btnClass = "comment-edit-box__btn comment-edit-box__btn--image tooltip tooltip--top-right"
        const btnClose = "comment-edit__import-close"

        
        // Crée un formulaire inline
        const form = document.createElement('form');
        form.className = 'comment-edit-form';
        form.innerHTML = `
            <div class="bloc__textarea">
                <textarea type="text" class="comment-edit__textarea" name="comment">${escapeHTML(originalText)}</textarea>
            </div>
            
            <div class="image-import ${ extraClass ?? '' }">
                <input type="file" name="import__photo" class="image-import__input ${ inputClass ?? '' }" accept="image/jpeg,image/jpg,image/png" hidden>
                <div class="image-import__preview ${ previewClass ?? '' }">
                    <img src="${ escapeHTML(imgSrc) }" alt="Aperçu de l'image">
                </div>
                <div class="image-import__browse ${ btnClass ?? '' }" data-title="Importer une image"><i class="ri ri-image-fill ri-lg"></i></div>
                <div class="image-import__close ${ btnClose ?? '' }"><i class="ri ri-close-fill"></i></div>
            </div>
            <input type="hidden" name="remove_image" value="0">
            <div class="s-stack">
                <button class="btn btn-sm btn-primary" type="submit">Enregistrer</button>
                <button class="btn btn-sm btn-outlined-secondary cancel-edit" type="button">Annuler</button>
            </div>
        `;
        // Initialiser l'import d'image sur ce formulaire nouvellement créé
        if (window.initImageImport) window.initImageImport(form);
        // Ajout gestion suppression image
        const closeBtn = form.querySelector('.image-import__close');
        const removeInput = form.querySelector('input[name="remove_image"]');
        if (closeBtn && removeInput) {
            closeBtn.addEventListener('click', function() {
                removeInput.value = "1";
            });
        }
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

        // Désactive le bouton enregistrer si textarea vide
        const textarea = form.querySelector('textarea[name="comment"]');
        const submitBtn = form.querySelector('button[type="submit"]');
        if (textarea && submitBtn) {
            submitBtn.disabled = textarea.value.trim().length === 0;
            textarea.addEventListener('input', function() {
                submitBtn.disabled = this.value.trim().length === 0;
            });
        }
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
