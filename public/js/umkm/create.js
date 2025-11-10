function previewImages() {
    const input = document.getElementById("foto");
    const preview = document.getElementById("image-preview");
    preview.innerHTML = "";

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            const col = document.createElement("div");
            col.className = "col-md-3 mb-2";
            col.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <small class="text-muted">${file.name}</small>
                            </div>
                        </div>
                    `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    }
}

// Preview Google Maps logic
let originalMapUrl = "";

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("previewBtn")
        .addEventListener("click", function () {
            const url = document.getElementById("input_url").value.trim();
            const previewContainer =
                document.getElementById("previewContainer");
            const iframe = document.getElementById("previewIframe");

            if (!url) {
                alert("Silakan masukkan URL Google Maps terlebih dahulu");
                return;
            }

            originalMapUrl = url;

            previewContainer.style.display = "block";

            if (
                url.includes("maps.app.goo.gl") ||
                url.includes("goo.gl/maps")
            ) {
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
        });
});

function openOriginalMap() {
    if (originalMapUrl) {
        window.open(originalMapUrl, "_blank");
    } else {
        alert("URL Google Maps tidak tersedia");
    }
}

function generateEmbedUrl(url, iframe) {
    let embedUrl = "";

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
