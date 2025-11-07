document.addEventListener("DOMContentLoaded", function () {
    const categoryItems = document.querySelectorAll(".category-item");
    const articlesContainer = document.getElementById("articles-container");

    categoryItems.forEach((item) => {
        item.addEventListener("click", function () {
            categoryItems.forEach((i) => i.classList.remove("active"));

            this.classList.add("active");

            const type = this.getAttribute("data-type");
            const id = this.getAttribute("data-id");

            articlesContainer.innerHTML =
                '<div class="text-center py-5"><div class="spinner-border" role="status"></div></div>';

            fetch(`/api/articles/${type}/${id}`)
                .then((response) => response.json())
                .then((data) => {
                    let html = '<div class="row">';

                    if (data.articles && data.articles.length > 0) {
                        data.articles.forEach((post) => {
                            const images = post.image
                                ? JSON.parse(post.image)
                                : [];
                            const firstImage =
                                images.length > 0 ? images[0] : null;
                            let imageUrl = "/images/no-image.png";

                            if (firstImage) {
                                if (
                                    firstImage.startsWith("http://") ||
                                    firstImage.startsWith("https://")
                                ) {
                                    imageUrl = firstImage;
                                } else {
                                    imageUrl = `/storage/${firstImage}`;
                                }
                            }

                            const publishedDate = new Date(
                                post.published_at
                            ).toLocaleDateString("id-ID", {
                                day: "numeric",
                                month: "short",
                                year: "numeric",
                            });

                            let categoryTitle = "Umum";
                            if (post.headline && post.headline.title) {
                                categoryTitle = post.headline.title;
                            } else if (post.category && post.category.title) {
                                categoryTitle = post.category.title;
                            }

                            html += `
                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                            <a href="/post/show/${
                                                post.id
                                            }" class="article-card" style="text-decoration:none; color:inherit; display: block;">
                                                <div class="position-relative">
                                                    <img src="${imageUrl}" class="article-image" alt="${
                                post.title
                            }">
                                                    <span class="article-category">
                                                        ${categoryTitle}
                                                    </span>
                                                </div>
                                                <div class="article-content">
                                                    <h5 class="article-title">${
                                                        post.title
                                                    }</h5>
                                                    <div class="article-meta">
                                                        <i class="bi bi-calendar"></i> ${publishedDate}
                                                        <span class="mx-2">•</span>
                                                        <i class="bi bi-person"></i> Admin
                                                        <span class="mx-2">•</span>
                                                        <i class="bi bi-eye"></i> ${
                                                            post.views || 0
                                                        }
                                                    </div>
                                                    <p class="article-excerpt">
                                                        ${
                                                            post.description
                                                                ? post.description
                                                                      .replace(
                                                                          /<[^>]*>/g,
                                                                          ""
                                                                      )
                                                                      .substring(
                                                                          0,
                                                                          150
                                                                      ) + "..."
                                                                : ""
                                                        }
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    `;
                        });
                        html += "</div>";
                    } else {
                        html = `
                                    <div class="text-center py-5">
                                        <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                                        <h4 class="mt-3 text-muted">Tidak ada artikel</h4>
                                        <p class="text-muted">Belum ada artikel untuk kategori ini.</p>
                                    </div>
                                `;
                    }

                    articlesContainer.innerHTML = html;
                })
                .catch((error) => {
                    console.error("Error:", error);
                    articlesContainer.innerHTML =
                        '<div class="text-center py-5 text-danger">Terjadi kesalahan saat memuat artikel.</div>';
                });
        });
    });
});
