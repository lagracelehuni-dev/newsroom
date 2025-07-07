import { initImageImport } from './imageImport.js';

// Encapsulation pour éviter la pollution globale
(function() {
  document.addEventListener('DOMContentLoaded', function () {
    const SECTION_HOME = document.querySelector('.section--home');
    const COMMENT_BOX = document.querySelector('.comment-box');
    const COMMENT_BOX_CONTAINER = document.querySelector('.comment-box__container');
    const COMMENT_INPUT = document.querySelector('.comment-box__textarea');
    const COMMENT_BTN_IMG = document.querySelector('.comment-box__btn--image');
    const COMMENT_REPLY = document.querySelector('.comment-reply');
    const TRIGGER_REPLY = document.querySelectorAll('.trigger-reply');
    const REPLY_INPUT = document.querySelector('.comment-reply__textarea');
    const REPLY_CLOSE = document.querySelector('.comment-reply__close');
    const COMMENT_TRIGGER_MORE = document.querySelectorAll('.content-trigger--more');
    const COMMENT_CONTENT_PANNEL = document.querySelectorAll('.comment__content-pannel');
    const VIEWPROFILE_TRIGGER_MORE = document.querySelector('.article__viewprofile-more');
    const ARTICLE_VIEWPROFILE_PANNEL = document.querySelector('.article__viewprofile-pannel');

    let lastScrollY = 100;

    if (SECTION_HOME) {
      SECTION_HOME.addEventListener('scroll', function () {
        let currentScroll = SECTION_HOME.clientHeight + SECTION_HOME.scrollTop;
        if(COMMENT_BOX && COMMENT_REPLY) {
          if (currentScroll >= lastScrollY) {
            COMMENT_BOX.style.bottom = '0px';
            COMMENT_REPLY.style.bottom = '0px';
          } else {
            COMMENT_BOX.style.bottom = COMMENT_BOX_CONTAINER.classList.contains('is-active') ? '-300px' : '-75px';
            // Si tu utilises l'import universel, adapte ici si besoin
            COMMENT_REPLY.style.bottom = '-343px';
          }
        }
        currentScroll = lastScrollY;
      });

      if (COMMENT_INPUT) {
        COMMENT_INPUT.addEventListener('focus', function () {
          COMMENT_INPUT.classList.add('is-focus');
          COMMENT_BOX_CONTAINER.classList.add('is-active');
          COMMENT_BTN_IMG.classList.replace('tooltip--top-right', 'tooltip--top-left-5');
        });

        // Délégation d'événement pour le menu '...'
        document.addEventListener('click', function(event) {
          // Ouvre le panel d'action du commentaire
          const trigger = event.target.closest('.content-trigger--more');
          if (trigger) {
            event.preventDefault();
            // Ferme tous les panels d'abord
            document.querySelectorAll('.comment__content-pannel').forEach(panel => panel.style.display = 'none');
            document.querySelectorAll('.content-trigger--more').forEach(t => t.classList.remove('is-active'));
            // Ouvre le panel lié à ce bouton
            const commentHeader = trigger.closest('.comment__content-header');
            if (commentHeader) {
              const panel = commentHeader.querySelector('.comment__content-pannel');
              if (panel) {
                panel.style.display = 'block';
                trigger.classList.add('is-active');
              }
            }
            return;
          }
          // Ferme le panel si clic hors
          if (!event.target.closest('.content-trigger--more') && !event.target.closest('.comment__content-pannel')) {
            document.querySelectorAll('.content-trigger--more').forEach(t => t.classList.remove('is-active'));
            document.querySelectorAll('.comment__content-pannel').forEach(panel => panel.style.display = 'none');
          }
        });

        // Répondre à un commentaire
        TRIGGER_REPLY.forEach(trigger => {
          trigger.addEventListener('click', () => {
            COMMENT_REPLY.querySelector('.p__replyto span').textContent = "@" + trigger.dataset.commentUsername || 'Utilisateur';
            COMMENT_REPLY.classList.add('is-visible');
            COMMENT_BOX.style.display = 'none';
          });
        });

        // Fermer la zone de réponse
        REPLY_CLOSE.addEventListener('click', function () {
          COMMENT_REPLY.classList.remove('is-visible');
          REPLY_INPUT.value = '';
          COMMENT_BOX.style.display = 'flex';
          COMMENT_BOX_CONTAINER.classList.remove('is-active');
          // Réinitialiser l'import image dans la zone de réponse
          COMMENT_REPLY.querySelectorAll('.image-import').forEach((importBloc) => {
            const fileInput = importBloc.querySelector('.image-import__input');
            const imgBloc = importBloc.querySelector('.image-import__preview');
            const closeBtn = importBloc.querySelector('.image-import__close');
            const img = imgBloc ? imgBloc.querySelector('img') : null;
            if (imgBloc) imgBloc.style.display = 'none';
            if (closeBtn) closeBtn.style.display = 'none';
            importBloc.classList.remove('is-import');
            if (img) img.src = '';
            if (fileInput) fileInput.value = '';
          });
        });

        // Initialisation de l'import image sur tout le document (ou cible spécifique)
        initImageImport(document, COMMENT_BOX_CONTAINER);

        // Si clic hors de la box commentaire ou de la box reply
        window.addEventListener('click', function (event) {
          const isInCommentBox = event.target.closest('.comment-box');
          const isInCommentReply = event.target.closest('.comment-reply');
          // Si ni dans la box commentaire ni dans la box reply
          if (!isInCommentBox && !isInCommentReply) {
            // Si la zone de réponse n'est PAS visible, on ferme tous les imports image
            if (!COMMENT_REPLY.classList.contains('is-visible')) {
              document.querySelectorAll('.image-import').forEach((importBloc) => {
                const fileInput = importBloc.querySelector('.image-import__input');
                const imgBloc = importBloc.querySelector('.image-import__preview');
                const closeBtn = importBloc.querySelector('.image-import__close');
                const img = imgBloc ? imgBloc.querySelector('img') : null;
                if (imgBloc) imgBloc.style.display = 'none';
                if (closeBtn) closeBtn.style.display = 'none';
                importBloc.classList.remove('is-import');
                if (img) img.src = '';
                if (fileInput) fileInput.value = '';
              });
            }
            if (COMMENT_INPUT) COMMENT_INPUT.classList.remove('is-focus');
            if (COMMENT_BOX_CONTAINER) COMMENT_BOX_CONTAINER.classList.remove('is-active');
            if (COMMENT_BTN_IMG) COMMENT_BTN_IMG.classList.replace('tooltip--top-left-5', 'tooltip--top-right');
          }
        });
      }

      // Gérer l'affichage de l'onglet profil
      if (VIEWPROFILE_TRIGGER_MORE && ARTICLE_VIEWPROFILE_PANNEL) {
        VIEWPROFILE_TRIGGER_MORE.addEventListener('click', function () {
          ARTICLE_VIEWPROFILE_PANNEL.style.display = 'block';
          VIEWPROFILE_TRIGGER_MORE.classList.add('is-active');
        });
        window.addEventListener('click', function (event) {
          if (
            !event.target.closest('.article__viewprofile-more') &&
            !event.target.closest('.article__viewprofile-pannel')
          ) {
            ARTICLE_VIEWPROFILE_PANNEL.style.display = 'none';
            VIEWPROFILE_TRIGGER_MORE.classList.remove('is-active');
          }
        });
      }
    }

    // Réinitialise aussi les triggers JS sur les nouveaux commentaires dès le chargement initial
    if (typeof window.initCommentTriggers === 'function') {
        window.initCommentTriggers();
    }
  });
})();

// Fonction globale pour réinitialiser les triggers JS sur les nouveaux commentaires
window.initCommentTriggers = function() {
    // Sélecteurs à réinitialiser (exemple : bouton répondre)
    const TRIGGER_REPLY = document.querySelectorAll('.trigger-reply');
    const COMMENT_REPLY = document.querySelector('.comment-reply');
    const COMMENT_BOX = document.querySelector('.comment-box');
    const COMMENT_BOX_CONTAINER = document.querySelector('.comment-box__container');
    const REPLY_INPUT = document.querySelector('.comment-reply__textarea');
    const REPLY_PARENT_ID = COMMENT_REPLY ? COMMENT_REPLY.querySelector('input[name="parent_id"]') : null;

    TRIGGER_REPLY.forEach(trigger => {
        trigger.onclick = function() {
            // Récupère l'id du commentaire ciblé (data-comment-id sur le .comment parent)
            const commentDiv = this.closest('.comment');
            if (commentDiv && REPLY_PARENT_ID) {
                REPLY_PARENT_ID.value = commentDiv.dataset.commentId;
            }
            if (COMMENT_REPLY) COMMENT_REPLY.classList.add('is-visible');
            if (COMMENT_BOX) COMMENT_BOX.style.display = 'none';
        };
    });

    // (Optionnel) Réinitialiser la fermeture de la zone de réponse si besoin
    const REPLY_CLOSE = document.querySelector('.comment-reply__close');
    if (REPLY_CLOSE && COMMENT_REPLY && COMMENT_BOX && COMMENT_BOX_CONTAINER && REPLY_INPUT) {
        REPLY_CLOSE.onclick = function() {
            COMMENT_REPLY.classList.remove('is-visible');
            REPLY_INPUT.value = '';
            if (REPLY_PARENT_ID) REPLY_PARENT_ID.value = '';
            COMMENT_BOX.style.display = 'flex';
            COMMENT_BOX_CONTAINER.classList.remove('is-active');
        };
    }
};

