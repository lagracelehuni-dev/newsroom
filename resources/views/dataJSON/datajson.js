let articlesData = [];
let currentCategoryIndex = 0;
let articlesPerLoad = 10;

function loadMoreArticles() {
    if (currentCategoryIndex >= articlesData.length) {
        document.getElementById("home-body__loading").style.display = "none";
        return;
    }

    let container = document.querySelector(".home-body");
    let category = articlesData[currentCategoryIndex];

    let articlesToLoad = category.articles.slice(0, articlesPerLoad);
    articlesToLoad.forEach(article => {
        let articleDiv = document.createElement("div");
        articleDiv.classList.add("article--posted");
        articleDiv.innerHTML = `
                <div class="article--posted__img"
                style="background-image: url({{'${article.image}'}})"
                data-img="${article.image}">
                    <div class="overlay-h"></div>
                </div>
                <div class="article--posted__content">
                    <div class="article-posted__head">
                        <div class="posted__head--profil">
                            <img src="${article.author_profile}" alt="lagracelehuni">
                        </div>
                        <div class="posted__head--infos">
                            <a href="#" class="head--infos--name">${article.author_name}</a>
                            <i class="ri ri-circle-fill"></i>
                            <p class="head--infos--datepost">${article.publication_time}</p>
                        </div>
                    </div>
                    <div class="posted__content-body">
                        <!-- Redaction -->
                        <div class="article--posted__redaction">
                            <h2 class="redaction-title">"${article.title}"</h2>
                            <p class="redaction-desc">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nisi reiciendis rerum possimus. Eos autem beatae itaque aliquam consequatur. Cum veniam, corrupti molestiae obcaecati ad vero commodi laboriosam rerum nulla sit dicta debitis repellendus inventore aut soluta! Voluptas provident id autem facere quisquam rerum inventore adipisci a distinctio pariatur unde enim, esse at, minima necessitatibus voluptatum harum repellendus. Rerum fugiat dolore veritatis explicabo eum assumenda. Fuga iste earum, hic temporibus ipsum animi repellendus corrupti nemo quos minus magni quasi quod recusandae error vel quis aliquid sed nesciunt nostrum minima. Dignissimos nam nemo temporibus, debitis et odit voluptatem fugiat possimus molestiae deserunt.
                            </p>
                            <a href="article-details.html" class="btn-readmore"><i class="ri ri-file-list-3-line"></i> Lire l'article</a>
                        </div>
                        
                        <!-- Category -->
                        <div class="article--posted__infos">
                            <a href="{{ route('cybersecurite') }}" class="tag-type">${category.category}</a>
                            <i class="ri ri-circle-fill"></i>
                            <p class="timeread">${article.reading_time} de lecture</p>
                        </div>
                    </div>
                    <div class="posted__content-footer">
                        <div class="article---posted__footer--reaction">
                            <!-- Like -->
                            <button class="btn-react react--like" title="liker"><i class="ri ri-heart-line ri-lg"></i> <p>${article.likes}</p></button>
                            <!-- comment -->
                            <button class="btn-react react--comment" title="commenter"><i class="ri ri-chat-1-line ri-lg"></i> <p>${article.comments}</p></button>
                            <!-- share -->
                            <button class="btn-react react--share" title="partager"><i class="ri ri-share-line ri-lg"></i> <p>${article.shares}</p></button>
                            <!-- share -->
                            <button class="btn-react react--saved" title="Enregister"><i class="ri ri-bookmark-line ri-lg"></i></button>
                        </div>
                    </div>
                </div>
        `;
    });

    container.appendChild(articleDiv);
    currentCategoryIndex++;
}

function handleScroll() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
        document.getElementById("home-body__loading").style.display = "block";
        setTimeout(loadMoreArticles, 1000);
    }
}

fetch("articles.json")
    .then(response => response.json())
    .then(data => {
        articlesData = data.articles;
        loadMoreArticles();
        window.addEventListener("scroll", handleScroll);
    })
    .catch(error => console.error("Erreur de chargement du JSON :", error));