document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchDocument");
    const dataFilter = document.querySelector('select[name="data_filter"]');
    const table = document.getElementById("documentsTable");
    const rows = table.querySelectorAll("tbody tr");

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const filterValue = dataFilter.value;

        rows.forEach((row) => {
            const title = row
                .querySelector("td:nth-child(2)")
                .textContent.toLowerCase();
            const dataCell = row.querySelector("td:nth-child(3)");
            const dataTitle = dataCell.textContent;
            const dataId = dataCell.getAttribute("data-id");

            let show = true;

            // Filter by search
            if (searchValue && !title.includes(searchValue)) {
                show = false;
            }

            // Filter by data
            if (filterValue !== "all") {
                if (filterValue === "no_data" && dataTitle !== "No Data") {
                    show = false;
                } else if (
                    filterValue !== "no_data" &&
                    dataId !== filterValue
                ) {
                    show = false;
                }
            }

            row.style.display = show ? "" : "none";
        });
    }

    searchInput.addEventListener("input", filterTable);
    dataFilter.addEventListener("change", filterTable);
});

// Download Document Report Function
function downloadDocumentReport() {
    const loadingBtn = event.target;
    const originalContent = loadingBtn.innerHTML;

    // Show loading state
    loadingBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
    loadingBtn.disabled = true;

    // Create form to download PDF
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/admin/documents/report";
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
