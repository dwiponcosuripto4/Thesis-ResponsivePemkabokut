document.getElementById("add-dropdown").addEventListener("click", function () {
    const dropdownSection = document.querySelector(".dropdown-section");
    const newDropdown = `
                <div class="dropdown-entry mt-4">
                    <div class="mb-3">
                        <label for="dropdown_title_${dropdownIndex}" class="form-label">Dropdown Title</label>
                        <input type="text" name="dropdowns[new_${dropdownIndex}][title]" class="form-control" placeholder="Enter dropdown title" required>
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_link_${dropdownIndex}" class="form-label">Dropdown Link</label>
                        <input type="url" name="dropdowns[new_${dropdownIndex}][link]" class="form-control" placeholder="Enter dropdown link" required>
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_icon_dropdown_${dropdownIndex}" class="form-label">Dropdown Icon (Image)</label>
                        <input type="file" name="dropdowns[new_${dropdownIndex}][icon_dropdown]" class="form-control" accept="image/*">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-dropdown">Delete Dropdown</button>
                </div>
            `;
    dropdownSection.insertAdjacentHTML("beforeend", newDropdown);
    dropdownIndex++;
});

// Remove dropdown entry
document.addEventListener("click", function (event) {
    if (event.target && event.target.matches(".remove-dropdown")) {
        const entry = event.target.closest(".dropdown-entry");
        entry.remove();
    }
});
