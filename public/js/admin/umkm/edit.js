// Preview new photo before upload
function previewNewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (max 2MB)
        if (file.size > 2048 * 1024) {
            alert("Ukuran file terlalu besar! Maksimal 2MB");
            event.target.value = "";
            return;
        }

        // Validate file type
        const validTypes = [
            "image/jpeg",
            "image/jpg",
            "image/png",
            "image/gif",
        ];
        if (!validTypes.includes(file.type)) {
            alert("Format file tidak valid! Gunakan JPG, PNG, atau GIF");
            event.target.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("newPhotoImg").src = e.target.result;
            document.getElementById("newPhotoPreview").style.display = "block";

            // Scroll to preview
            document.getElementById("newPhotoPreview").scrollIntoView({
                behavior: "smooth",
                block: "nearest",
            });
        };
        reader.readAsDataURL(file);
    }
}

// Cancel photo upload
function cancelPhotoUpload() {
    document.getElementById("foto").value = "";
    document.getElementById("newPhotoPreview").style.display = "none";
}
function showPreview(url) {
    const previewContainer = document.getElementById("previewContainer");
    const iframe = document.getElementById("previewIframe");
    if (!url) {
        previewContainer.style.display = "none";
        iframe.src = "";
        return;
    }
    previewContainer.style.display = "block";
    // Check if it's a short URL
    if (url.includes("maps.app.goo.gl") || url.includes("goo.gl/maps")) {
        fetch("/umkm/expand-url", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
            body: JSON.stringify({
                url: url,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success && data.expandedUrl) {
                    generateEmbedUrl(data.expandedUrl, iframe);
                    originalMapUrl = data.expandedUrl;
                } else {
                    generateEmbedUrl(url, iframe);
                }
            })
            .catch((error) => {
                console.error("Error expanding URL:", error);
                generateEmbedUrl(url, iframe);
            });
    } else {
        generateEmbedUrl(url, iframe);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    // Tampilkan preview otomatis jika ada input_url
    const url = document.getElementById("input_url").value.trim();
    if (url) {
        showPreview(url);
    }
});

function openOriginalMapEdit() {
    if (originalMapUrl) {
        window.open(originalMapUrl, "_blank");
    } else {
        alert("URL Google Maps tidak tersedia");
    }
}

function generateEmbedUrl(url, iframe) {
    let embedUrl = "";
    // Try to extract lat,lng from URL
    let match = url.match(/@(-?\d+(?:\.\d+)?),\s*(-?\d+(?:\.\d+)?)/);
    if (match) {
        const lat = match[1];
        const lng = match[2];
        embedUrl = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d${lng}!3d${lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40sNsKwMDAnMDAuMCJTIDEwN8KwMzEnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid`;
    } else if (url) {
        embedUrl = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d106.8456!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNyJTIDEwNsKwNTAnNDQuMiJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid`;
    } else {
        embedUrl = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000!2d106.8456!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNyJTIDEwNsKwNTAnNDQuMiJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid`;
    }
    iframe.src = embedUrl;
}
