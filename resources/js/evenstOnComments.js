document.querySelectorAll('.comment__content-responses').forEach(btn => {
    btn.addEventListener('click', function () {
        const wrapper = btn.closest('.comment'); // ou autre conteneur unique
        const textShow = wrapper.querySelector('.text__show-responses');
        const textHide = wrapper.querySelector('.text__hide-responses');
        const icon = btn.querySelector('i');
        const replyContainer = wrapper.querySelector('.comment__replies-container');

        const isVisible = textHide.style.display === "block";

        textHide.style.display = isVisible ? "none" : "block";
        textShow.style.display = isVisible ? "block" : "none";
        icon.classList.toggle('is--show', !isVisible);
        icon.classList.toggle('is--hide', isVisible);
        replyContainer.style.display = isVisible ? "none" : "block";
    });
});
