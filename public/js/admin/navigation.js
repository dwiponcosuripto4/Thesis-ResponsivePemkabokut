// Set initial sidebar state for desktop only
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const toggleBtn = document.getElementById("sidebarToggle");

    // Only collapse sidebar on desktop (> 768px)
    if (window.innerWidth > 768) {
        sidebar.classList.add("collapsed");
        mainContent.classList.add("expanded");
        toggleBtn.style.left = "85px";
    }
});

// Sidebar toggle functionality (Desktop)
document.getElementById("sidebarToggle").addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const toggleBtn = document.getElementById("sidebarToggle");

    sidebar.classList.toggle("collapsed");
    if (mainContent) {
        mainContent.classList.toggle("expanded");
    }

    // Update toggle button position
    if (sidebar.classList.contains("collapsed")) {
        toggleBtn.style.left = "85px";
    } else {
        toggleBtn.style.left = "265px";
    }
});

// Mobile hamburger menu toggle
document.getElementById("navbarToggle").addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const mainContent = document.getElementById("mainContent");
    const navbar = document.querySelector(".navbar");

    sidebar.classList.toggle("show");
    overlay.classList.toggle("show");

    // Add mobile-shifted class on mobile devices
    if (window.innerWidth <= 768) {
        mainContent.classList.toggle("mobile-shifted");
        navbar.classList.toggle("mobile-shifted");
    }

    // Prevent body scroll when sidebar is open
    if (sidebar.classList.contains("show")) {
        document.body.style.overflow = "hidden";
    } else {
        document.body.style.overflow = "";
    }
});

// Close sidebar when clicking overlay (Mobile)
document
    .getElementById("sidebarOverlay")
    .addEventListener("click", function () {
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("sidebarOverlay");
        const mainContent = document.getElementById("mainContent");
        const navbar = document.querySelector(".navbar");

        sidebar.classList.remove("show");
        overlay.classList.remove("show");

        // Remove mobile-shifted class
        if (window.innerWidth <= 768) {
            mainContent.classList.remove("mobile-shifted");
            navbar.classList.remove("mobile-shifted");
        }

        document.body.style.overflow = "";
    });

// Close sidebar when clicking a nav link on mobile
if (window.innerWidth <= 768) {
    document.querySelectorAll(".sidebar .nav-link").forEach(function (link) {
        link.addEventListener("click", function () {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebarOverlay");
            const mainContent = document.getElementById("mainContent");
            const navbar = document.querySelector(".navbar");

            sidebar.classList.remove("show");
            overlay.classList.remove("show");

            // Remove mobile-shifted class
            mainContent.classList.remove("mobile-shifted");
            navbar.classList.remove("mobile-shifted");

            document.body.style.overflow = "";
        });
    });
}

// Submenu toggle
document.querySelectorAll(".has-submenu > .nav-link").forEach(function (link) {
    link.addEventListener("click", function (e) {
        e.preventDefault();
        const parent = this.parentElement;
        parent.classList.toggle("open");
    });
});

// Handle window resize - remove mobile-shifted class when switching to desktop
window.addEventListener("resize", function () {
    const mainContent = document.getElementById("mainContent");
    const navbar = document.querySelector(".navbar");

    if (window.innerWidth > 768) {
        mainContent.classList.remove("mobile-shifted");
        navbar.classList.remove("mobile-shifted");
    }
});

// Mobile Modal Functions
function openMobileModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add("show");
        document.body.style.overflow = "hidden";
    }
}

function closeMobileModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove("show");
        document.body.style.overflow = "";
    }
}

// Mobile Notification Button
document
    .getElementById("mobileNotificationBtn")
    ?.addEventListener("click", function (e) {
        e.preventDefault();
        loadPendingBusinessesForMobile();
        openMobileModal("mobileNotificationModal");
    });

// Mobile Profile Button
document
    .getElementById("mobileProfileBtn")
    ?.addEventListener("click", function (e) {
        e.preventDefault();
        openMobileModal("mobileProfileModal");
    });

// Close Modal Buttons
document
    .getElementById("closeNotificationModal")
    ?.addEventListener("click", function () {
        closeMobileModal("mobileNotificationModal");
    });

document
    .getElementById("closeProfileModal")
    ?.addEventListener("click", function () {
        closeMobileModal("mobileProfileModal");
    });

// Close modal when clicking overlay
document.querySelectorAll(".mobile-modal-overlay").forEach(function (overlay) {
    overlay.addEventListener("click", function () {
        const modal = this.closest(".mobile-modal");
        if (modal) {
            modal.classList.remove("show");
            document.body.style.overflow = "";
        }
    });
});

// Mobile Settings Toggle
document
    .getElementById("mobileSettingsToggle")
    ?.addEventListener("click", function () {
        const submenu = document.getElementById("mobileSettingsSubmenu");
        const icon = this.querySelector(".fa-chevron-down");

        if (submenu) {
            submenu.classList.toggle("show");
            if (icon) {
                icon.style.transform = submenu.classList.contains("show")
                    ? "rotate(180deg)"
                    : "rotate(0deg)";
            }
        }
    });

// Load pending businesses notification
function loadPendingBusinesses() {
    $.ajax({
        url: "/admin/api/pending-businesses",
        type: "GET",
        success: function (response) {
            const pendingCount = response.count || 0;
            const businesses = response.businesses || [];

            // Update notification count for both desktop and mobile
            $("#pendingCount, #pendingCountMobile").text(pendingCount);

            // Update badge visibility and color
            if (pendingCount > 0) {
                $("#pendingCount, #pendingCountMobile")
                    .removeClass("d-none")
                    .css("display", "flex")
                    .addClass("bg-danger text-white");
            } else {
                $("#pendingCount, #pendingCountMobile")
                    .addClass("d-none")
                    .css("display", "none");
            }

            // Update business list
            let businessHtml = "";
            if (businesses.length > 0) {
                businesses.forEach(function (business) {
                    // Handle foto array safely
                    let fotoUrl = "";
                    if (
                        business.foto &&
                        Array.isArray(business.foto) &&
                        business.foto.length > 0
                    ) {
                        fotoUrl = business.foto[0];
                    } else if (
                        business.foto &&
                        typeof business.foto === "string" &&
                        business.foto.trim() !== ""
                    ) {
                        // Handle case where foto might be a JSON string
                        try {
                            const fotoArray = JSON.parse(business.foto);
                            if (
                                Array.isArray(fotoArray) &&
                                fotoArray.length > 0
                            ) {
                                fotoUrl = fotoArray[0];
                            }
                        } catch (e) {
                            // If parsing fails, treat as single string
                            fotoUrl = business.foto;
                        }
                    }

                    businessHtml += `
                                <li>
                                    <a class="dropdown-item py-2" href="/admin/businesses/${
                                        business.id
                                    }">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                ${
                                                    fotoUrl
                                                        ? `<img src="/storage/${fotoUrl}" class="rounded-circle" width="32" height="32" style="object-fit: cover;">`
                                                        : ""
                                                }
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-truncate" style="max-width: 150px;">${
                                                    business.nama
                                                }</div>
                                            </div>
                                            <div class="ms-2">
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>`;
                });
            } else {
                businessHtml =
                    '<li><div class="dropdown-item-text text-center text-muted py-3">Tidak ada UMKM pending</div></li>';
            }

            $("#pendingBusinessList").html(businessHtml);
        },
        error: function () {
            $("#pendingBusinessList").html(
                '<li><div class="dropdown-item-text text-center text-muted py-3">Error loading data</div></li>'
            );
        },
    });
}

// Load pending businesses on page load
$(document).ready(function () {
    loadPendingBusinesses();

    // Refresh every 30 seconds
    setInterval(loadPendingBusinesses, 30000);
});

// Desktop notification dropdown toggle
$("#pendingBusinessNotification").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    const dropdown = $("#notificationDropdown");
    const isVisible = dropdown.css("display") === "block";

    // Close user profile dropdown if open
    $("#userProfileMenu").css("display", "none");

    if (!isVisible) {
        loadPendingBusinesses();
        dropdown.css("display", "block");
    } else {
        dropdown.css("display", "none");
    }
});

// Desktop user profile dropdown toggle
$("#userProfileDropdown").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    const dropdown = $("#userProfileMenu");
    const isVisible = dropdown.css("display") === "block";

    // Close notification dropdown if open
    $("#notificationDropdown").css("display", "none");

    if (!isVisible) {
        dropdown.css("display", "block");
    } else {
        dropdown.css("display", "none");
    }
});

// Close dropdowns when clicking outside
$(document).on("click", function (e) {
    if (!$(e.target).closest(".dropdown").length) {
        $("#notificationDropdown, #userProfileMenu").css("display", "none");
        $(".dropdown-submenu").removeClass("show");
    }
});

// Load pending businesses for mobile modal
function loadPendingBusinessesForMobile() {
    $.ajax({
        url: "/admin/api/pending-businesses",
        type: "GET",
        success: function (response) {
            const businesses = response.businesses || [];
            let businessHtml = "";

            if (businesses.length > 0) {
                businesses.forEach(function (business) {
                    let fotoUrl = "";
                    if (
                        business.foto &&
                        Array.isArray(business.foto) &&
                        business.foto.length > 0
                    ) {
                        fotoUrl = business.foto[0];
                    } else if (
                        business.foto &&
                        typeof business.foto === "string" &&
                        business.foto.trim() !== ""
                    ) {
                        try {
                            const fotoArray = JSON.parse(business.foto);
                            if (
                                Array.isArray(fotoArray) &&
                                fotoArray.length > 0
                            ) {
                                fotoUrl = fotoArray[0];
                            }
                        } catch (e) {
                            fotoUrl = business.foto;
                        }
                    }

                    businessHtml += `
                                <a href="/admin/businesses/${
                                    business.id
                                }" class="mobile-notification-item">
                                    ${
                                        fotoUrl
                                            ? `<img src="/storage/${fotoUrl}" class="mobile-notification-avatar">`
                                            : `<div class="mobile-notification-avatar" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-store" style="color: #6c757d;"></i>
                                                </div>`
                                    }
                                    <div class="mobile-notification-content">
                                        <div class="mobile-notification-title">${
                                            business.nama
                                        }</div>
                                    </div>
                                    <span class="badge bg-warning text-dark mobile-notification-badge">Pending</span>
                                </a>`;
                });
            } else {
                businessHtml = `
                            <div class="mobile-notification-empty">
                                <i class="fas fa-bell-slash d-block"></i>
                                <p>Tidak ada UMKM pending</p>
                            </div>`;
            }

            $("#mobileNotificationBody").html(businessHtml);
        },
        error: function () {
            $("#mobileNotificationBody").html(`
                        <div class="mobile-notification-empty">
                            <i class="fas fa-exclamation-triangle d-block"></i>
                            <p>Error loading data</p>
                        </div>`);
        },
    });
}

// UMKM Settings Toggle Functions
function toggleUmkmRegistration(checkbox) {
    const isHidden = checkbox.checked;

    // Sync both checkboxes
    $("#hideUmkmRegistration, #hideUmkmRegistrationMobile").prop(
        "checked",
        isHidden
    );

    // Send AJAX request to update setting
    $.ajax({
        url: "/admin/settings/toggle-umkm-registration",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            hide_registration: isHidden,
        },
        success: function (response) {
            if (response.success) {
                // Show success message
                showToast(
                    isHidden
                        ? "UMKM Registration hidden"
                        : "UMKM Registration shown",
                    "success"
                );
            }
        },
        error: function () {
            // Revert both checkboxes if error
            $("#hideUmkmRegistration, #hideUmkmRegistrationMobile").prop(
                "checked",
                !isHidden
            );
            showToast("Error updating setting", "error");
        },
    });
}

function toggleUmkmMenu(checkbox) {
    const isHidden = checkbox.checked;

    // Sync both checkboxes
    $("#hideUmkmMenu, #hideUmkmMenuMobile").prop("checked", isHidden);

    // Send AJAX request to update setting
    $.ajax({
        url: "/admin/settings/toggle-umkm-menu",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            hide_menu: isHidden,
        },
        success: function (response) {
            if (response.success) {
                // Show success message
                showToast(
                    isHidden ? "UMKM Menu hidden" : "UMKM Menu shown",
                    "success"
                );
            }
        },
        error: function () {
            // Revert both checkboxes if error
            $("#hideUmkmMenu, #hideUmkmMenuMobile").prop("checked", !isHidden);
            showToast("Error updating setting", "error");
        },
    });
}

// Toast notification function
function showToast(message, type) {
    const toast = $(`
                <div class="toast align-items-center text-white bg-${
                    type === "success" ? "success" : "danger"
                } border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `);

    // Add toast container if it doesn't exist
    if ($("#toast-container").length === 0) {
        $("body").append(
            '<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>'
        );
    }

    $("#toast-container").append(toast);

    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast[0]);
    bsToast.show();

    // Remove toast element after it's hidden
    toast.on("hidden.bs.toast", function () {
        $(this).remove();
    });
}

// Load current settings on page load
function loadCurrentSettings() {
    $.ajax({
        url: "/admin/settings/get-umkm-settings",
        method: "GET",
        success: function (response) {
            if (response.success) {
                // Sync both desktop and mobile settings
                $("#hideUmkmRegistration, #hideUmkmRegistrationMobile").prop(
                    "checked",
                    response.data.hide_registration
                );
                $("#hideUmkmMenu, #hideUmkmMenuMobile").prop(
                    "checked",
                    response.data.hide_menu
                );
            }
        },
        error: function () {
            console.log("Error loading settings");
        },
    });
}

// Load settings when page loads
$(document).ready(function () {
    loadCurrentSettings();

    // Handle dropdown submenu click
    $(".dropdown-submenu .dropdown-toggle").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        // Close other submenus
        $(".dropdown-submenu").not($(this).parent()).removeClass("show");

        // Toggle current submenu
        $(this).parent(".dropdown-submenu").toggleClass("show");
    });

    // Close submenu when clicking outside
    $(document).on("click", function (e) {
        if (!$(e.target).closest(".dropdown-submenu").length) {
            $(".dropdown-submenu").removeClass("show");
        }
    });

    // Prevent submenu from closing when clicking inside it
    $(".dropdown-submenu .dropdown-menu").on("click", function (e) {
        e.stopPropagation();
    });
});
