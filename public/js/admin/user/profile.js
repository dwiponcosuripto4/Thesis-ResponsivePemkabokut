document.addEventListener("DOMContentLoaded", function () {
    const photoInput = document.getElementById("foto");
    const photoPreview = document.getElementById("profilePhotoPreview");

    if (photoInput && photoPreview) {
        photoInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert("Ukuran file terlalu besar. Maksimal 2MB.");
                    this.value = "";
                    return;
                }

                // Validate file type
                const allowedTypes = [
                    "image/jpeg",
                    "image/png",
                    "image/jpg",
                    "image/gif",
                ];
                if (!allowedTypes.includes(file.type)) {
                    alert(
                        "Format file tidak didukung. Gunakan: JPEG, PNG, JPG, atau GIF."
                    );
                    this.value = "";
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    if (photoPreview.tagName === "IMG") {
                        photoPreview.src = e.target.result;
                    } else {
                        // Replace div with img
                        const newImg = document.createElement("img");
                        newImg.src = e.target.result;
                        newImg.className = "rounded-circle img-thumbnail";
                        newImg.width = 150;
                        newImg.height = 150;
                        newImg.style.objectFit = "cover";
                        newImg.id = "profilePhotoPreview";
                        photoPreview.parentNode.replaceChild(
                            newImg,
                            photoPreview
                        );
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Confirm password change
    const passwordForm = document.querySelector('form[action*="password"]');
    if (passwordForm) {
        passwordForm.addEventListener("submit", function (e) {
            const currentPassword =
                document.getElementById("current_password").value;
            const newPassword = document.getElementById("password").value;
            const confirmPassword = document.getElementById(
                "password_confirmation"
            ).value;

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert("Password baru dan konfirmasi password tidak sama.");
                return;
            }

            if (newPassword.length < 8) {
                e.preventDefault();
                alert("Password baru minimal 8 karakter.");
                return;
            }

            if (!confirm("Yakin ingin mengubah password?")) {
                e.preventDefault();
            }
        });
    }

    // Form validation enhancement
    const forms = document.querySelectorAll("form");
    forms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';

                // Re-enable after 3 seconds in case of error
                setTimeout(function () {
                    submitBtn.disabled = false;
                    if (submitBtn.innerHTML.includes("Memproses")) {
                        submitBtn.innerHTML = submitBtn.innerHTML.replace(
                            '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...',
                            submitBtn.dataset.originalText || "Submit"
                        );
                    }
                }, 3000);
            }
        });
    });

    // Store original button text
    document.querySelectorAll('button[type="submit"]').forEach(function (btn) {
        btn.dataset.originalText = btn.innerHTML;
    });
});
