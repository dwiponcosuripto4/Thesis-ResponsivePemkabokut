let fileIndex = 1;
document.getElementById("add-file").addEventListener("click", function () {
    const fileSection = document.querySelector(".file-section");
    const newFile = `
                <div class="file-entry mt-4">
                    <div class="mb-3">
                        <label for="file_title" class="form-label">File Title</label>
                        <input type="text" name="files[${fileIndex}][title]" class="form-control" placeholder="Enter file title">
                    </div>
                    <div class="mb-3">
                        <label for="file_path" class="form-label">Choose File</label>
                        <input type="file" name="files[${fileIndex}][file]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png,.zip,.rar,.xls,.xlsx">
                    </div>
                </div>
            `;
    fileSection.insertAdjacentHTML("beforeend", newFile);
    fileIndex++;
});

// Inisialisasi Select2
document.addEventListener("DOMContentLoaded", function () {
    $("#data-select").select2({
        placeholder: "-- Select Data --",
        allowClear: true,
        width: "100%",
    });
});
