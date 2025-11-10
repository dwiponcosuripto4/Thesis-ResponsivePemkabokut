document.addEventListener("DOMContentLoaded", function () {
    initLightbox();
});

function initLightbox() {
    const lightbox = document.createElement("div");
    lightbox.className = "lightbox";
    lightbox.innerHTML =
        '<span class="lightbox-close">&times;</span><img src="" alt="">';
    document.body.appendChild(lightbox);

    const lightboxImg = lightbox.querySelector("img");
    const closeBtn = lightbox.querySelector(".lightbox-close");

    document.addEventListener(
        "click",
        function (e) {
            if (e.target.matches(".lightbox-trigger")) {
                e.preventDefault();
                e.stopPropagation();

                const img = e.target;
                lightboxImg.src = img.src;
                lightboxImg.alt = img.alt;
                lightbox.classList.add("active");
                document.body.style.overflow = "hidden";
            }
        },
        true
    );

    lightbox.addEventListener("click", function (e) {
        if (e.target === lightbox || e.target === closeBtn) {
            lightbox.classList.remove("active");
            document.body.style.overflow = "";
        }
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && lightbox.classList.contains("active")) {
            lightbox.classList.remove("active");
            document.body.style.overflow = "";
        }
    });
}
