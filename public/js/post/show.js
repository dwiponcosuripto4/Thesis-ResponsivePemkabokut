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
            // Check if clicked element is an image inside description
            if (e.target.matches(".description img")) {
                e.preventDefault(); // Prevent default link behavior
                e.stopPropagation(); // Stop event from bubbling up

                const img = e.target;
                lightboxImg.src = img.src;
                lightboxImg.alt = img.alt;
                lightbox.classList.add("active");
                document.body.style.overflow = "hidden";
            }
        },
        true
    ); // Use capture phase to catch event before link

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
