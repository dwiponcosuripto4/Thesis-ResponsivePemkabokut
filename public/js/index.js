document.addEventListener("DOMContentLoaded", function () {
    var submenuToggles = document.querySelectorAll(".submenu-toggle");
    var backdrop = null;

    // Create backdrop element
    function createBackdrop() {
        if (!backdrop) {
            backdrop = document.createElement("div");
            backdrop.className = "submenu-backdrop";
            document.body.appendChild(backdrop);

            // Close on backdrop click
            backdrop.addEventListener("click", function () {
                closeAllSubmenus();
            });
        }
        return backdrop;
    }

    // Close all submenus
    function closeAllSubmenus() {
        document
            .querySelectorAll(".submenu-collapse")
            .forEach(function (submenu) {
                submenu.classList.remove("show");
            });

        // Hide backdrop
        if (backdrop) {
            backdrop.classList.remove("show");
        }
    }

    // Get portal title by icon ID
    function getPortalTitle(iconId) {
        var iconContainer = document
            .querySelector('[data-icon-id="' + iconId + '"]')
            .closest(".icon-container");
        var titleElement = iconContainer.querySelector(".portal-title p");
        return titleElement ? titleElement.textContent.trim() : "Menu";
    }

    // Wrap submenu content with header and content div
    function wrapSubmenuContent(submenu, title) {
        // Check if already wrapped
        if (submenu.querySelector(".popup-header")) {
            // Update title if needed
            var titleElement = submenu.querySelector(".popup-header h3");
            if (titleElement) {
                titleElement.textContent = title;
            }
            // Re-attach close button event to ensure it works
            var closeBtn = submenu.querySelector(".popup-header .close-btn");
            if (closeBtn) {
                // Remove old listeners by cloning
                var newCloseBtn = closeBtn.cloneNode(true);
                closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
                // Add new listener
                newCloseBtn.addEventListener("click", function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    closeAllSubmenus();
                });
            }
            return;
        }

        // Get the original content
        var content = submenu.innerHTML;

        // Create header
        var header = document.createElement("div");
        header.className = "popup-header";
        header.innerHTML =
            "<h3>" +
            title +
            '</h3><button class="close-btn" aria-label="Close">×</button>';

        // Create content wrapper
        var contentDiv = document.createElement("div");
        contentDiv.className = "popup-content";
        contentDiv.innerHTML = content;

        // Clear and rebuild submenu
        submenu.innerHTML = "";
        submenu.appendChild(header);
        submenu.appendChild(contentDiv);

        // Add close button event
        var closeBtn = header.querySelector(".close-btn");
        closeBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            e.preventDefault();
            closeAllSubmenus();
        });
    }

    // Check if mobile on resize
    window.addEventListener("resize", function () {
        closeAllSubmenus();
    });

    submenuToggles.forEach(function (toggle) {
        toggle.addEventListener("click", function (event) {
            event.preventDefault();

            var iconId = this.getAttribute("data-icon-id");
            var selectedSubmenu = document.getElementById("iconMenu" + iconId);
            var isCurrentlyOpen = selectedSubmenu.classList.contains("show");

            // Close all submenus first
            closeAllSubmenus();

            // If it wasn't open, open it
            if (!isCurrentlyOpen) {
                // Get portal title and wrap content for both desktop and mobile
                var title = getPortalTitle(iconId);
                wrapSubmenuContent(selectedSubmenu, title);

                // Show backdrop
                var bd = createBackdrop();
                bd.classList.add("show");

                // Show submenu
                selectedSubmenu.classList.add("show");
            }
        });
    });

    // Close on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeAllSubmenus();
        }
    });
});

$(document).ready(function () {
    // Initialize Hero Carousel
    var heroOwl = $("#heroCarousel").owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        autoHeight: false,
        smartSpeed: 5000,
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        items: 1,
        touchDrag: false,
        mouseDrag: false,
        pullDrag: false,
        freeDrag: false,
    });

    // Initialize Berita Terkini Carousel
    var owl = $("#latestArticle").owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        autoHeight: false,
        smartSpeed: 5000,
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        touchDrag: false,
        mouseDrag: false,
        pullDrag: false,
        freeDrag: false,
        stagePadding: 0,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
        onInitialized: function () {
            // Prevent focus/scroll on initialization
            $("#latestArticle").find(".owl-item.active").attr("tabindex", "-1");
        },
        onTranslated: function () {
            // Prevent focus/scroll after transition
            $("#latestArticle").find(".owl-item").attr("tabindex", "-1");
        },
    });

    // Custom Navigation Events
    $(".owl-next").click(function () {
        owl.trigger("next.owl.carousel");
    });
    $(".owl-prev").click(function () {
        owl.trigger("prev.owl.carousel");
    });

    // Pause/Play Button
    var isPlaying = true;
    $("#pausePlayBtn").click(function () {
        if (isPlaying) {
            owl.trigger("stop.owl.autoplay");
            $(this).html('<i class="bi bi-play-fill"></i>');
            isPlaying = false;
        } else {
            owl.trigger("play.owl.autoplay", [5000]);
            $(this).html('<i class="bi bi-pause-fill"></i>');
            isPlaying = true;
        }
    });

    // Prevent auto-scroll to carousel on mobile
    if (window.innerWidth <= 767) {
        var carouselSection = document.querySelector("#pengumuman-section");
        var latestArticleCarousel = document.querySelector("#latestArticle");

        if (latestArticleCarousel) {
            // Prevent focus on carousel elements
            latestArticleCarousel.addEventListener(
                "focus",
                function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                },
                true
            );

            // Prevent scroll into view
            var observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (
                        mutation.type === "attributes" &&
                        mutation.attributeName === "class"
                    ) {
                        var scrollY = window.scrollY;
                        requestAnimationFrame(function () {
                            if (Math.abs(window.scrollY - scrollY) > 50) {
                                window.scrollTo(0, scrollY);
                            }
                        });
                    }
                });
            });

            var owlItems = latestArticleCarousel.querySelectorAll(".owl-item");
            owlItems.forEach(function (item) {
                observer.observe(item, {
                    attributes: true,
                    attributeFilter: ["class"],
                });
                item.setAttribute("tabindex", "-1");
            });
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Prevent auto-scroll on mobile when animations trigger
    var scrollPosition =
        window.pageYOffset || document.documentElement.scrollTop;

    var welcome = document.getElementById("welcomePopup");
    var info = document.getElementById("infoPopup");

    setTimeout(function () {
        welcome.classList.add("show");
        // Restore scroll position after animation
        window.scrollTo(0, scrollPosition);
    }, 200);

    setTimeout(function () {
        info.classList.add("show");
        // Restore scroll position after animation
        window.scrollTo(0, scrollPosition);
    }, 900);
});
