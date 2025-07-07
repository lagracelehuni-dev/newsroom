(function() {
    // Function to check if an element is truncated
    function isTruncated(element) {
        return element.scrollHeight > element.clientHeight || element.scrollWidth > element.clientWidth;
    }

    // Example usage
    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.profil__bio');
        elements.forEach(el => {
            if (isTruncated(el)) {
                el.classList.add('is-truncated');
                el.addEventListener('click', () => {
                    el.classList.toggle('show-more')                   
                })
            } else {
                el.classList.remove('is-truncated');
            }
        });
    });
})();