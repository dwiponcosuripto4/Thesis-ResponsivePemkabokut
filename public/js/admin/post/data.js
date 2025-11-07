// Image Lightbox Functions
function openLightbox(imageSrc) {
    const lightbox = document.getElementById("imageLightbox");
    const lightboxImage = document.getElementById("lightboxImage");
    lightboxImage.src = imageSrc;
    lightbox.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeLightbox() {
    const lightbox = document.getElementById("imageLightbox");
    lightbox.classList.remove("active");
    document.body.style.overflow = "auto";
}

// Close lightbox when clicking outside the image
document.addEventListener("click", function (event) {
    const lightbox = document.getElementById("imageLightbox");
    if (event.target === lightbox) {
        closeLightbox();
    }
});

// Close lightbox with Escape key
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeLightbox();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Search functionality
    const searchInput = document.getElementById("searchPost");
    const searchInputMobile = document.getElementById("searchPostMobile");
    const table = document.getElementById("postsTable");
    const filterForm = document.getElementById("filterForm");
    const filterFormMobile = document.getElementById("filterFormMobile");

    function filterTable(inputElement) {
        const searchTerm = inputElement.value.toLowerCase();
        const rows = table
            .getElementsByTagName("tbody")[0]
            .getElementsByTagName("tr");
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];

            // Skip empty state row
            if (row.cells.length === 1) continue;

            const title = row.cells[2].textContent.toLowerCase();
            const author = row.cells[3].textContent.toLowerCase();
            const category = row.cells[4].textContent.toLowerCase();

            const matchesSearch =
                title.includes(searchTerm) ||
                author.includes(searchTerm) ||
                category.includes(searchTerm);

            if (matchesSearch) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        }

        // Update results counter
        updateResultsCounter(visibleCount, inputElement);
    }

    function updateResultsCounter(count, inputElement) {
        const existingCounter = document.getElementById("searchResultsCounter");
        if (existingCounter) {
            existingCounter.remove();
        }

        if (inputElement.value.length > 0) {
            const counter = document.createElement("small");
            counter.id = "searchResultsCounter";
            counter.className = "text-muted ms-2";
            counter.textContent = `(${count} result${
                count !== 1 ? "s" : ""
            } found)`;
            inputElement.parentNode.parentNode.appendChild(counter);
        }
    }

    // Add loading state to filter selects
    function addLoadingState(select) {
        if (select) {
            select.style.opacity = "0.6";
            select.disabled = true;
        }
    }

    function removeLoadingState(select) {
        if (select) {
            select.style.opacity = "1";
            select.disabled = false;
        }
    }

    // Enhanced filter change handling for desktop
    const categorySelect = document.querySelector(
        '#filterForm select[name="category_filter"]'
    );
    const headlineSelect = document.querySelector(
        '#filterForm select[name="headline_filter"]'
    );

    if (categorySelect) {
        categorySelect.addEventListener("change", function () {
            addLoadingState(this);
            addLoadingState(headlineSelect);
        });
    }

    if (headlineSelect) {
        headlineSelect.addEventListener("change", function () {
            addLoadingState(this);
            addLoadingState(categorySelect);
        });
    }

    // Enhanced filter change handling for mobile
    const categorySelectMobile = document.querySelector(
        '#filterFormMobile select[name="category_filter"]'
    );
    const headlineSelectMobile = document.querySelector(
        '#filterFormMobile select[name="headline_filter"]'
    );

    if (categorySelectMobile) {
        categorySelectMobile.addEventListener("change", function () {
            addLoadingState(this);
            addLoadingState(headlineSelectMobile);
        });
    }

    if (headlineSelectMobile) {
        headlineSelectMobile.addEventListener("change", function () {
            addLoadingState(this);
            addLoadingState(categorySelectMobile);
        });
    }

    // Search event listeners
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            filterTable(this);
            // Sync with mobile search
            if (searchInputMobile) {
                searchInputMobile.value = this.value;
            }
        });
    }

    if (searchInputMobile) {
        searchInputMobile.addEventListener("input", function () {
            filterTable(this);
            // Sync with desktop search
            if (searchInput) {
                searchInput.value = this.value;
            }
        });
    }

    // Clear search when filters change
    if (filterForm) {
        filterForm.addEventListener("submit", function () {
            if (searchInput) searchInput.value = "";
            if (searchInputMobile) searchInputMobile.value = "";
        });
    }

    if (filterFormMobile) {
        filterFormMobile.addEventListener("submit", function () {
            if (searchInput) searchInput.value = "";
            if (searchInputMobile) searchInputMobile.value = "";
        });
    }
});

// Delete post function
function deletePost(postId, postTitle) {
    if (confirm(`Are you sure you want to delete "${postTitle}"?`)) {
        // Create form and submit
        const form = document.createElement("form");
        form.method = "POST";
        form.action = `/admin/post/delete/${postId}`;

        const csrfToken = document.createElement("input");
        csrfToken.type = "hidden";
        csrfToken.name = "_token";
        csrfToken.value = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        const methodField = document.createElement("input");
        methodField.type = "hidden";
        methodField.name = "_method";
        methodField.value = "DELETE";

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Toast notification for better UX
function showToast(message, type) {
    const toastHtml = `
                <div class="toast align-items-center text-white bg-${
                    type === "success" ? "success" : "danger"
                } border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

    if (!document.getElementById("toast-container")) {
        document.body.insertAdjacentHTML(
            "beforeend",
            '<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>'
        );
    }

    const toastContainer = document.getElementById("toast-container");
    toastContainer.insertAdjacentHTML("beforeend", toastHtml);

    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    toastElement.addEventListener("hidden.bs.toast", () => {
        toastElement.remove();
    });
}

// Download Post Report Function
function downloadPostReport() {
    const loadingBtn = event.target;
    const originalContent = loadingBtn.innerHTML;

    // Show loading state
    loadingBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
    loadingBtn.disabled = true;

    // Create form to download PDF
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/admin/posts/report";
    form.style.display = "none";

    // Add CSRF token
    const csrfToken = document.createElement("input");
    csrfToken.type = "hidden";
    csrfToken.name = "_token";
    csrfToken.value = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    form.appendChild(csrfToken);
    document.body.appendChild(form);
    form.submit();

    // Reset button after delay
    setTimeout(() => {
        loadingBtn.innerHTML = originalContent;
        loadingBtn.disabled = false;
        document.body.removeChild(form);
    }, 3000);
}
