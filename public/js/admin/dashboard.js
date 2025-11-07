// Function to update current date and time
function updateDateTime() {
    const now = new Date();
    const days = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
    ];
    const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    const dayName = days[now.getDay()];
    const day = now.getDate();
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    const hours = now.getHours().toString().padStart(2, "0");
    const minutes = now.getMinutes().toString().padStart(2, "0");

    const dateTimeString = `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes} WIB`;

    const dateTimeElement = document.getElementById("currentDateTime");
    if (dateTimeElement) {
        dateTimeElement.textContent = dateTimeString;
    }
}

// CSRF Token for AJAX requests
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$(document).on("click", ".approve-btn", function () {
    const businessId = $(this).data("id");
    const button = $(this);

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
