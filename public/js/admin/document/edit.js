let fileIndex = 1;

// Function to add new file section
function addFileSection() {
    const fileSections = document.getElementById("file-sections");
    const newSection = document.createElement("div");
    newSection.className = "file-section mb-3 p-3 border rounded";
    newSection.innerHTML = `
        <div class="row g-2">
            <div class="col-12 col-md-5">
                <label class="form-label">File Title</label>
                <input type="text" class="form-control form-control-sm" name="files[${fileIndex}][title]" placeholder="Enter file title">
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label">Upload File</label>
                <input type="file" class="form-control form-control-sm" name="files[${fileIndex}][file]">
            </div>
            <div class="col-12 col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-file-section w-100" style="min-height: 38px;">
                    <i class="fas fa-trash me-1"></i>
                    <span class="d-inline">Remove</span>
                </button>
            </div>
        </div>
    `;
    fileSections.appendChild(newSection);
    fileIndex++;
}

// Event listener untuk tombol Add File
document
    .getElementById("add-file-btn")
    .addEventListener("click", addFileSection);

// Event delegation untuk tombol Remove
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-file-section")) {
        const fileSections = document.querySelectorAll(".file-section");
        if (fileSections.length > 1) {
            e.target.closest(".file-section").remove();
        } else {
            alert("At least one file section is required.");
        }
    }

    // Handle delete existing file
    if (e.target.classList.contains("delete-existing-file")) {
        const fileId = e.target.getAttribute("data-file-id");
        const fileWrapper = e.target.closest(".file-item-wrapper");

        if (confirm("Are you sure you want to delete this file?")) {
            // Disable button to prevent double click
            e.target.disabled = true;
            e.target.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            // Send AJAX request to delete file
            fetch(`/admin/file/${fileId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Add fade out animation
                        fileWrapper.style.transition = "opacity 0.3s ease";
                        fileWrapper.style.opacity = "0";
                        
                        // Remove the file element from DOM after animation
                        setTimeout(() => {
                            fileWrapper.remove();
                            alert("File deleted successfully");
                        }, 300);
                    } else {
                        alert(data.message || "Error deleting file");
                        // Re-enable button
                        e.target.disabled = false;
                        e.target.innerHTML = "×";
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Error deleting file: " + error.message);
                    // Re-enable button
                    e.target.disabled = false;
                    e.target.innerHTML = "×";
                });
        }
    }
});

// Inisialisasi Select2
document.addEventListener("DOMContentLoaded", function () {
    $("#data-select").select2({
        placeholder: "-- Select Data --",
        allowClear: true,
        width: "100%",
    });
});
