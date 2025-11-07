$(document).ready(function () {
    // Validasi form dengan styling baru
    $("#create-post-form").on("submit", function (e) {
        let valid = true;

        // Reset all error messages
        $(".error-message").removeClass("show").hide();

        // Title required
        const title = $("#title").val().trim();
        if (!title) {
            $("#title-error")
                .text("Title wajib diisi.")
                .addClass("show")
                .show();
            $("#title").focus();
            valid = false;
        }

        // Minimal salah satu category atau headline harus dipilih
        const category = $("#category-select").val();
        const headline = $("#headline-select").val();
        if (!category && !headline) {
            $("#category-error")
                .text("Pilih minimal salah satu Category atau Headline.")
                .addClass("show")
                .show();
            $("#headline-error")
                .text("Pilih minimal salah satu Category atau Headline.")
                .addClass("show")
                .show();
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            // Smooth scroll to first error
            $("html, body").animate(
                {
                    scrollTop:
                        $(".error-message.show:first").offset().top - 100,
                },
                500
            );
        }
    });
    // Set initial sidebar state for desktop only
    if ($(window).width() > 768) {
        $("#sidebar").addClass("collapsed");
        $("#mainContent").addClass("expanded");
        $("#sidebarToggle").css("left", "85px");
    }

    // Desktop sidebar toggle functionality
    $("#sidebarToggle").click(function () {
        const sidebar = $("#sidebar");
        const mainContent = $("#mainContent");
        const toggleBtn = $("#sidebarToggle");

        sidebar.toggleClass("collapsed");
        mainContent.toggleClass("expanded");

        // Update toggle button position
        if (sidebar.hasClass("collapsed")) {
            toggleBtn.css("left", "85px");
        } else {
            toggleBtn.css("left", "265px");
        }
    });

    // Mobile hamburger menu toggle
    $("#mobileHamburger").click(function () {
        const sidebar = $("#sidebar");
        const overlay = $("#sidebarOverlay");
        const hamburger = $("#mobileHamburger");
        const mainContent = $("#mainContent");
        const topNavbar = $(".top-navbar");

        if (sidebar.hasClass("show")) {
            // Close sidebar
            sidebar.removeClass("show");
            overlay.removeClass("show");
            hamburger.removeClass("shifted");

            // Remove mobile-shifted class on mobile
            if ($(window).width() <= 768) {
                mainContent.removeClass("mobile-shifted");
                topNavbar.removeClass("mobile-shifted");
            }

            $("body").css("overflow", "");
        } else {
            // Open sidebar
            sidebar.addClass("show");
            overlay.addClass("show");
            hamburger.addClass("shifted");

            // Add mobile-shifted class on mobile
            if ($(window).width() <= 768) {
                mainContent.addClass("mobile-shifted");
                topNavbar.addClass("mobile-shifted");
            }

            $("body").css("overflow", "hidden");
        }
    });

    // Close sidebar when clicking overlay (Mobile)
    $("#sidebarOverlay").click(function () {
        const sidebar = $("#sidebar");
        const overlay = $("#sidebarOverlay");
        const hamburger = $("#mobileHamburger");
        const mainContent = $("#mainContent");
        const topNavbar = $(".top-navbar");

        sidebar.removeClass("show");
        overlay.removeClass("show");
        hamburger.removeClass("shifted");

        // Remove mobile-shifted class
        if ($(window).width() <= 768) {
            mainContent.removeClass("mobile-shifted");
            topNavbar.removeClass("mobile-shifted");
        }

        $("body").css("overflow", "");
    });

    // Close sidebar when clicking a nav link on mobile
    if ($(window).width() <= 768) {
        $(".sidebar .nav-link").click(function () {
            const sidebar = $("#sidebar");
            const overlay = $("#sidebarOverlay");
            const hamburger = $("#mobileHamburger");
            const mainContent = $("#mainContent");
            const topNavbar = $(".top-navbar");

            sidebar.removeClass("show");
            overlay.removeClass("show");
            hamburger.removeClass("shifted");

            // Remove mobile-shifted class
            mainContent.removeClass("mobile-shifted");
            topNavbar.removeClass("mobile-shifted");

            $("body").css("overflow", "");
        });
    }

    // Handle window resize - remove mobile-shifted class when switching to desktop
    $(window).on("resize", function () {
        const mainContent = $("#mainContent");
        const topNavbar = $(".top-navbar");

        if ($(window).width() > 768) {
            mainContent.removeClass("mobile-shifted");
            topNavbar.removeClass("mobile-shifted");
        }
    });

    // Initialize Summernote dengan kustomisasi untuk styling modern
    $("#description").summernote({
        placeholder: "Write your post content here...",
        tabsize: 2,
        height: 300,
        dialogsInBody: true,
        dialogsFade: true,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline", "clear"]],
            ["fontname", ["fontname"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["table", ["table"]],
            ["insert", ["link", "picture", "video"]],
            ["view", ["fullscreen", "codeview", "help"]],
        ],
        callbacks: {
            onInit: function () {
                // Fix z-index for modals
                $(".note-modal").each(function () {
                    $(this).css("z-index", 2000);
                });
            },
            onDialogShown: function () {
                // Ensure dialog is above backdrop
                $(".note-modal").css("z-index", 2000);
                $(".note-modal-backdrop").css("z-index", 1999);
                $(".modal-backdrop").css("z-index", 1999);
            },
        },
    });

    // Initialize Select2 dengan styling modern
    $("#category-select").select2({
        placeholder: "Choose a category",
        allowClear: true,
        width: "100%",
        dropdownCssClass: "modern-dropdown",
    });

    $("#headline-select").select2({
        placeholder: "Choose a headline",
        allowClear: true,
        width: "100%",
        dropdownCssClass: "modern-dropdown",
    });

    // Input animations dan interactions
    $(".modern-input, .modern-select")
        .on("focus", function () {
            $(this).parent().addClass("focused");
        })
        .on("blur", function () {
            if (!$(this).val()) {
                $(this).parent().removeClass("focused");
            }
        });

    // Real-time validation feedback
    $("#title").on("input", function () {
        const value = $(this).val().trim();
        const errorDiv = $("#title-error");

        if (value.length === 0) {
            errorDiv.text("Title is required").addClass("show").show();
            $(this).css("border-color", "#ff6b6b");
        } else if (value.length < 10) {
            errorDiv
                .text("Title should be at least 10 characters")
                .addClass("show")
                .show();
            $(this).css("border-color", "#ffa500");
        } else {
            errorDiv.removeClass("show").hide();
            $(this).css("border-color", "#48bb78");
        }
    });

    // Drag and drop functionality for image upload
    const uploadZone = document.querySelector(".upload-zone");

    uploadZone.addEventListener("dragover", function (e) {
        e.preventDefault();
        this.classList.add("drag-over");
        this.style.borderColor = "#667eea";
        this.style.background =
            "linear-gradient(135deg, #f0f4ff 0%, #e6f0ff 100%)";
    });

    uploadZone.addEventListener("dragleave", function (e) {
        e.preventDefault();
        this.classList.remove("drag-over");
        this.style.borderColor = "#cbd5e0";
        this.style.background =
            "linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)";
    });

    uploadZone.addEventListener("drop", function (e) {
        e.preventDefault();
        this.classList.remove("drag-over");
        this.style.borderColor = "#cbd5e0";
        this.style.background =
            "linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)";

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            updateImagePreview(files);
        }
    });

    const imageInput = document.getElementById("image-upload");
    const imagePreviewContainer = document.getElementById("image-preview");
    let selectedImages = new DataTransfer();

    // Fungsi untuk memperbarui pratinjau gambar dengan ukuran asli
    function updateImagePreview(files) {
        Array.from(files).forEach((file, index) => {
            const imageItem = document.createElement("div");
            imageItem.classList.add("file-item");

            const imageElement = document.createElement("img");
            const objectUrl = URL.createObjectURL(file);
            imageElement.src = objectUrl;

            // Biarkan gambar tampil dengan ukuran asli (dengan batas maksimal)
            imageElement.style.maxWidth = "300px";
            imageElement.style.height = "auto";
            imageElement.style.display = "block";
            imageElement.style.borderRadius = "12px";

            // Tambahkan info gambar
            const imageInfo = document.createElement("div");
            imageInfo.classList.add("image-info");

            // Format ukuran file
            const fileSize = (file.size / 1024).toFixed(1) + " KB";
            if (file.size > 1024 * 1024) {
                fileSize = (file.size / (1024 * 1024)).toFixed(1) + " MB";
            }

            imageInfo.innerHTML = `${file.name}<br>${fileSize}`;

            // Load gambar untuk mendapatkan dimensi asli
            imageElement.onload = function () {
                const dimensions = `${this.naturalWidth}×${this.naturalHeight}`;
                imageInfo.innerHTML = `${file.name}<br>${fileSize} • ${dimensions}px`;
            };

            const removeBtn = document.createElement("button");
            removeBtn.classList.add("remove-file-btn");
            removeBtn.innerHTML = "&times;";
            removeBtn.type = "button";

            // Hapus gambar ketika tombol X diklik
            removeBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                imageItem.style.opacity = "0";
                imageItem.style.transform = "scale(0.8)";

                setTimeout(() => {
                    imageItem.remove();
                    selectedImages.items.remove(index);
                    imageInput.files = selectedImages.files;

                    if (selectedImages.items.length === 0) {
                        imageInput.value = "";
                    }
                    // Clean up object URL
                    URL.revokeObjectURL(objectUrl);
                }, 200);
            });

            imageItem.appendChild(imageElement);
            imageItem.appendChild(imageInfo);
            imageItem.appendChild(removeBtn);
            imagePreviewContainer.appendChild(imageItem);
            selectedImages.items.add(file);

            // Animation for new items
            imageItem.style.opacity = "0";
            imageItem.style.transform = "scale(0.8)";
            setTimeout(() => {
                imageItem.style.transition = "all 0.3s ease";
                imageItem.style.opacity = "1";
                imageItem.style.transform = "scale(1)";
            }, 50);
        });

        imageInput.files = selectedImages.files;
    }

    // Tombol "Add Image" memicu pemilihan gambar
    document
        .getElementById("add-image-btn")
        .addEventListener("click", function () {
            imageInput.click();
        });

    // Perbarui pratinjau ketika gambar dipilih
    imageInput.addEventListener("change", function (event) {
        updateImagePreview(event.target.files);
    });

    // Load pending businesses notification
    function loadPendingBusinesses() {
        $.ajax({
            url: "/admin/api/pending-businesses",
            type: "GET",
            success: function (response) {
                const pendingCount = response.count || 0;
                const businesses = response.businesses || [];

                // Update notification count
                $("#pendingCount").text(pendingCount);

                // Update badge visibility
                if (pendingCount > 0) {
                    $("#pendingCount").css("display", "flex").show();
                } else {
                    $("#pendingCount").hide();
                }

                // Update business list
                let businessHtml = "";
                if (businesses.length > 0) {
                    businesses.forEach(function (business) {
                        businessHtml += `
                                    <li>
                                        <a href="/admin/businesses/${
                                            business.id
                                        }" style="padding: 8px 15px; display: block;">
                                            <div style="display: flex; align-items: center;">
                                                <div style="margin-right: 10px;">
                                                    ${
                                                        business.foto &&
                                                        business.foto.length > 0
                                                            ? `<img src="/storage/${business.foto[0]}" class="img-circle" width="32" height="32" style="object-fit: cover;">`
                                                            : `<div class="img-circle" style="width: 32px; height: 32px; background-color: #6c757d; color: white; display: flex; align-items: center; justify-content: center; font-size: 12px;">${business.nama
                                                                  .substring(
                                                                      0,
                                                                      2
                                                                  )
                                                                  .toUpperCase()}</div>`
                                                    }
                                                </div>
                                                <div style="flex-grow: 1;">
                                                    <div style="font-weight: bold; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${
                                                        business.nama
                                                    }</div>
                                                    <div style="color: #6c757d; font-size: 12px;">${
                                                        business.email
                                                    }</div>
                                                </div>
                                                <div style="margin-left: 10px;">
                                                    <span class="label label-warning">Pending</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>`;
                    });
                } else {
                    businessHtml =
                        '<li><div style="padding: 15px; text-align: center; color: #6c757d;">Tidak ada UMKM pending</div></li>';
                }

                $("#pendingBusinessList").html(businessHtml);
            },
            error: function () {
                $("#pendingBusinessList").html(
                    '<li><div style="padding: 15px; text-align: center; color: #6c757d;">Error loading data</div></li>'
                );
            },
        });
    }

    // Load pending businesses on page load
    loadPendingBusinesses();

    // Refresh every 30 seconds
    setInterval(loadPendingBusinesses, 30000);

    // Refresh when dropdown is clicked
    $("#pendingBusinessNotification").on("click", function () {
        loadPendingBusinesses();
    });

    // Enhanced form submission with loading states
    $("#create-post-form").on("submit", function (e) {
        const submitBtn = $(".btn-publish");
        const originalText = submitBtn.html();

        // Add loading state
        submitBtn
            .addClass("loading")
            .html('<i class="fas fa-spinner fa-spin"></i> Publishing...')
            .prop("disabled", true);

        // If validation passes, keep the loading state
        // The form will submit naturally
        setTimeout(() => {
            if (!e.isDefaultPrevented()) {
                return;
            } else {
                // If validation failed, restore button
                submitBtn
                    .removeClass("loading")
                    .html(originalText)
                    .prop("disabled", false);
            }
        }, 100);
    });

    // Save as draft functionality
    $(".btn-draft").on("click", function () {
        const btn = $(this);
        const originalText = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin"></i> Saving Draft...').prop(
            "disabled",
            true
        );

        // Add draft field to form
        const draftInput = $(
            '<input type="hidden" name="save_as_draft" value="1">'
        );
        $("#create-post-form").append(draftInput);

        // Submit form
        $("#create-post-form").submit();
    });

    // Auto-save draft functionality (optional)
    let autoSaveTimeout;
    $("#title, #description").on("input", function () {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(function () {
            // Auto-save logic here (optional)
            console.log("Auto-saving draft...");
        }, 5000); // Save after 5 seconds of inactivity
    });

    // Character counter for title
    $("#title").on("input", function () {
        const current = $(this).val().length;
        const max = 255;
        const remaining = max - current;

        let counterHtml = `<small class="char-counter ${
            remaining < 20 ? "text-warning" : ""
        } ${
            remaining < 0 ? "text-danger" : ""
        }">${current}/${max} characters</small>`;

        // Remove existing counter
        $(this).parent().find(".char-counter").remove();

        // Add counter
        $(this).parent().append(counterHtml);
    });

    // Smooth animations for form sections
    $(".form-section").each(function (index) {
        $(this).css({
            opacity: "0",
            transform: "translateY(20px)",
        });

        setTimeout(() => {
            $(this).css({
                transition: "all 0.6s ease",
                opacity: "1",
                transform: "translateY(0)",
            });
        }, index * 100);
    });

    // Form progress tracking
    function updateProgress() {
        let filledFields = 0;
        let totalFields = 4;

        // Check title
        if ($("#title").val().trim()) filledFields++;

        // Check category or headline
        if ($("#category-select").val() || $("#headline-select").val())
            filledFields++;

        // Check description
        if (
            $("#description").summernote("code").trim() &&
            $("#description").summernote("code") !== "<p><br></p>"
        )
            filledFields++;

        // Check publish date
        if ($("#published_at").val()) filledFields++;

        const percentage = (filledFields / totalFields) * 100;
        $("#formProgress").css("width", percentage + "%");
    }

    // Track progress on input changes
    $("#title, #published_at").on("input", updateProgress);
    $("#category-select, #headline-select").on("change", updateProgress);
    $("#description").on("summernote.change", updateProgress);

    // Initial progress check
    setTimeout(updateProgress, 1000);

    // Add tooltips to buttons
    $(".btn-publish").attr("data-tooltip", "Publish your post immediately");
    $(".btn-draft").attr("data-tooltip", "Save as draft for later editing");
});
