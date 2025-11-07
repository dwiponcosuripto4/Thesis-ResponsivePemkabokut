document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchUser");
    const filterStatus = document.getElementById("filterStatus");
    const table = document.getElementById("userTable");

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = filterStatus.value;
        const tbody = table.querySelector("tbody");

        if (!tbody) return;

        const rows = tbody.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];

            if (row.cells.length < 8) continue;

            const nameCell = row.cells[2];
            const emailCell = row.cells[3];
            const statusCell = row.cells[5];

            if (!nameCell || !emailCell || !statusCell) continue;

            const name = nameCell.textContent.toLowerCase();
            const email = emailCell.textContent.toLowerCase();
            const statusBadge = statusCell.querySelector(".badge");

            if (!statusBadge) continue;

            const statusText = statusBadge.textContent.toLowerCase();
            let status = "";
            if (
                statusText.includes("terverifikasi") &&
                !statusText.includes("belum")
            ) {
                status = "active";
            } else if (statusText.includes("belum")) {
                status = "inactive";
            }

            const matchesSearch =
                name.includes(searchTerm) || email.includes(searchTerm);
            const matchesStatus =
                statusFilter === "" || status === statusFilter;

            row.style.display = matchesSearch && matchesStatus ? "" : "none";
        }
    }

    if (searchInput && filterStatus) {
        searchInput.addEventListener("input", filterTable);
        filterStatus.addEventListener("change", filterTable);
    }
});

function viewUser(userId) {
    window.location.href = `/admin/users/${userId}`;
}

function deactivateUser(userId) {
    if (confirm("Apakah Anda yakin ingin menonaktifkan user ini?")) {
        fetch(`/admin/users/${userId}/deactivate`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showToast(data.message, "success");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message, "error");
                }
            })
            .catch((error) => {
                showToast("Terjadi kesalahan", "error");
                console.error("Error:", error);
            });
    }
}

function activateUser(userId) {
    if (confirm("Apakah Anda yakin ingin mengaktifkan user ini?")) {
        fetch(`/admin/users/${userId}/activate`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showToast(data.message, "success");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message, "error");
                }
            })
            .catch((error) => {
                showToast("Terjadi kesalahan", "error");
                console.error("Error:", error);
            });
    }
}

function verifyUser(userId) {
    if (confirm("Verifikasi user ini?")) {
        fetch(`/admin/users/${userId}/verify`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showToast(data.message, "success");
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message, "error");
                }
            })
            .catch((error) => {
                showToast("Terjadi kesalahan", "error");
                console.error("Error:", error);
            });
    }
}

function showToast(message, type) {
    const toastHtml = `
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

function downloadReport() {
    const loadingBtn = event.target;
    const originalContent = loadingBtn.innerHTML;

    loadingBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
    loadingBtn.disabled = true;

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/admin/users/report";
    form.style.display = "none";

    const csrfToken = document.createElement("input");
    csrfToken.type = "hidden";
    csrfToken.name = "_token";
    csrfToken.value = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    form.appendChild(csrfToken);
    document.body.appendChild(form);
    form.submit();

    setTimeout(() => {
        loadingBtn.innerHTML = originalContent;
        loadingBtn.disabled = false;
        document.body.removeChild(form);
    }, 3000);
}
