// CSRF Token for AJAX requests
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// Approve business function
$(document).on("click", ".approve-btn", function () {
    const businessId = $(this).data("id");

    Swal.fire({
        title: "Approve UMKM?",
        text: "Are you sure you want to approve this business?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, approve it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(`/admin/businesses/${businessId}/approve`)
                .done(function (response) {
                    if (response.success) {
                        Swal.fire("Approved!", response.message, "success");
                        location.reload();
                    }
                })
                .fail(function () {
                    Swal.fire("Error!", "Something went wrong.", "error");
                });
        }
    });
});

// Reject business function
$(document).on("click", ".reject-btn", function () {
    const businessId = $(this).data("id");

    Swal.fire({
        title: "Set to Pending?",
        text: "This will change the business status to pending.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ffc107",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, set to pending!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(`/admin/businesses/${businessId}/reject`)
                .done(function (response) {
                    if (response.success) {
                        Swal.fire("Changed!", response.message, "success");
                        location.reload();
                    }
                })
                .fail(function () {
                    Swal.fire("Error!", "Something went wrong.", "error");
                });
        }
    });
});

// Lightbox functionality
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
