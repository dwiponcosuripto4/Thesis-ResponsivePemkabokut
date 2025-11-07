// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token for AJAX requests
    if (typeof $ !== 'undefined') {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }

    // Status filter change handler
    const statusSelect = document.getElementById("status");
    if (statusSelect) {
        statusSelect.addEventListener("change", function () {
            const selectedValue = this.value;
            const filterForm = document.getElementById("filterForm");
            
            // If "All Status" is selected (empty value), remove status parameter
            if (selectedValue === '') {
                const statusInput = filterForm.querySelector('select[name="status"]');
                if (statusInput) {
                    statusInput.removeAttribute('name');
                }
            }
            
            filterForm.submit();
        });
    }

    // Search form enhancement - submit on Enter key
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                document.getElementById("searchForm").submit();
            }
        });
    }
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

// Delete business function
$(document).on("click", ".delete-btn", function () {
    const businessId = $(this).data("id");

    Swal.fire({
        title: "Delete UMKM?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/businesses/${businessId}`,
                type: "DELETE",
                success: function (response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.message, "success");
                        location.reload();
                    }
                },
                error: function () {
                    Swal.fire("Error!", "Something went wrong.", "error");
                },
            });
        }
    });
});

// Download Business Report Function
function downloadBusinessReport() {
    const loadingBtn = event.target;
    const originalContent = loadingBtn.innerHTML;

    // Show loading state
    loadingBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
    loadingBtn.disabled = true;

    // Create form to download PDF
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/admin/businesses/report";
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
