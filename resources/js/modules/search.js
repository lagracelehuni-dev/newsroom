// Encapsulation du module pour éviter la pollution globale
(function defineSearchModule() {
    // Sélection sécurisée des éléments DOM
    const CLOSE_SEARCHBAR = document.querySelector('.searchbar--close');
    const DISPLAY_SEARCHBAR = document.querySelector('.display');
    const DISPLAY_CONTENT = document.querySelector('.display__content');
    const articlesContainer = document.querySelector('.display__articles');
    const authorsContainer = document.querySelector('.display__authors');
    const displayMessage = document.querySelector('.display__msg');
    const searchInput = document.querySelector('.searchbar__input');

    if (!CLOSE_SEARCHBAR || !DISPLAY_SEARCHBAR || !DISPLAY_CONTENT || !articlesContainer || !authorsContainer || !displayMessage || !searchInput) {
        // Un ou plusieurs éléments nécessaires sont manquants, on ne fait rien
        return;
    }

    // Fonction de debouncing pour limiter le nombre d'exécutions de la recherche
    function debounce(func, delay) {
        let timer;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func(...args);
            }, delay);
        };
    }

    // Fonction principale de recherche
    function handleSearchInput() {
        let query = searchInput.value.toLowerCase();
        CLOSE_SEARCHBAR.style.display = 'block';

        if (query.length > 0) {
            DISPLAY_SEARCHBAR.style.display = 'flex';
            DISPLAY_SEARCHBAR.style.justifyContent = 'start';
            DISPLAY_CONTENT.style.display = 'flex';
            displayMessage.style.display = 'none';
        }

        // Effacer les résultats précédents
        while (articlesContainer.firstChild) articlesContainer.removeChild(articlesContainer.firstChild);
        while (authorsContainer.firstChild) authorsContainer.removeChild(authorsContainer.firstChild);

        // Charger les données JSON
        fetch('/json-data?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                if (!data.articles || !data.authors) {
                    DISPLAY_CONTENT.style.display = 'none';
                    displayMessage.style.display = 'block';
                    displayMessage.textContent = 'Erreur de chargement des données.';
                    return;
                }

                // Filtrer côté JS pour plus de souplesse (support multi-mots, insensible à la casse, tous les mots présents dans n'importe quel champ)
                let words = query.split(' ').filter(Boolean);
                let foundArticles = data.articles.filter(article =>
                    words.every(word => {
                        word = word.toLocaleLowerCase();
                        return (
                            (article.title && article.title.toLocaleLowerCase().includes(word)) ||
                            (article.category && article.category.toLocaleLowerCase().includes(word)) ||
                            (article.category_slug && article.category_slug.toLocaleLowerCase().includes(word))
                        );
                    })
                );

                let foundAuthors = data.authors.filter(author =>
                    words.every(word => {
                        word = word.toLocaleLowerCase();
                        return (
                            (author.name && author.name.toLocaleLowerCase().includes(word)) ||
                            (author.username && author.username.toLocaleLowerCase().includes(word))
                        );
                    })
                );

                // Afficher les résultats des articles
                foundArticles.forEach(article => {
                    let articleElement = document.createElement('a');
                    articleElement.classList.add('display__article-item');
                    articleElement.href = article.url || '#';

                    let iconDiv = document.createElement('div');
                    iconDiv.classList.add('display__articles-icon');
                    iconDiv.innerHTML = '<i class="ri-search-line ri-lg"></i>';

                    let textDiv = document.createElement('div');
                    textDiv.classList.add('display__articles-text');

                    let title = document.createElement('p');
                    title.classList.add('display__articles-title');
                    title.textContent = article.title;

                    let category = document.createElement('p');
                    category.classList.add('display__articles-category');
                    category.textContent = article.category;

                    textDiv.appendChild(title);
                    textDiv.appendChild(category);

                    articleElement.appendChild(iconDiv);
                    articleElement.appendChild(textDiv);
                    articlesContainer.appendChild(articleElement);
                });

                // Afficher les résultats des auteurs
                foundAuthors.forEach(author => {
                    let authorElement = document.createElement('a');
                    authorElement.classList.add('display__author-item');
                    authorElement.href = author.url || '#';

                    let avatarDiv = document.createElement('div');
                    avatarDiv.classList.add('display__author-avatar');
                    let img = document.createElement('img');
                    img.src = author.avatar ? `${author.avatar}` : '/assets/img/profil/default.jpg';
                    img.alt = 'Photo de profil';
                    avatarDiv.appendChild(img);

                    let infoDiv = document.createElement('div');
                    infoDiv.classList.add('display__author-infos');

                    let name = document.createElement('p');
                    name.classList.add('display__author-name');
                    name.textContent = author.name;

                    let username = document.createElement('p');
                    username.classList.add('display__author-username');
                    username.textContent = "@" + author.username;

                    infoDiv.appendChild(name);
                    infoDiv.appendChild(username);

                    authorElement.appendChild(avatarDiv);
                    authorElement.appendChild(infoDiv);
                    authorsContainer.appendChild(authorElement);


                });

                // Afficher un message si aucun résultat n'est trouvé
                if (foundArticles.length === 0 && foundAuthors.length === 0) {
                    DISPLAY_CONTENT.style.display = 'none';
                    displayMessage.style.display = 'block';
                    displayMessage.textContent = 'Aucun résultat trouvé. Essayez avec un autre terme.';
                } else if (query.length === 0) {
                    DISPLAY_SEARCHBAR.style.display = 'flex';
                    DISPLAY_CONTENT.style.display = 'none';
                    displayMessage.style.display = 'block';
                    displayMessage.textContent = 'Essayez de rechercher des auteurs, des articles ou des mots-clés.';
                } else {
                    DISPLAY_CONTENT.style.display = 'flex';
                    authorsContainer.style.display = "flex !important";
                    displayMessage.style.display = 'none';
                }
            })
            .catch(error => {
                DISPLAY_CONTENT.style.display = 'none';
                displayMessage.style.display = 'block';
                // Affiche l'erreur dans la console pour debug
                console.error('Erreur lors de la récupération JSON:', error);
                displayMessage.textContent = 'Erreur de chargement du fichier JSON. Vérifiez votre connexion ou contactez l\'administrateur.';
            });
    }

    // Utilisation du debouncing pour l'input
    searchInput.addEventListener('input', debounce(handleSearchInput, 500));

    // Cacher la barre de recherche lorsque l'on clique en dehors
    CLOSE_SEARCHBAR.addEventListener('click', function () {
        CLOSE_SEARCHBAR.style.display = 'none';
        DISPLAY_SEARCHBAR.style.display = 'none';
        searchInput.value = ""
    });
    window.addEventListener('click', function (event) {
        if (!event.target.closest('.searchbar') && !event.target.closest('.display')) {
            CLOSE_SEARCHBAR.style.display = 'none';
            DISPLAY_SEARCHBAR.style.display = 'none';
            searchInput.value = ""
        }
    });
})();
