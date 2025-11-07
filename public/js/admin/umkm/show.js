// CSRF Token for AJAX requests
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
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
