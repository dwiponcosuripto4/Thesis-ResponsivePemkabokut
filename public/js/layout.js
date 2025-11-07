window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 0) {
        navbar.classList.add('blur');
    } else {
        navbar.classList.remove('blur');
    }
});

document.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar-index');
    if (navbar) {
        if (window.scrollY > 0) {
            navbar.classList.add('blur');
        } else {
            navbar.classList.remove('blur');
        }
    }
});

$('#description').summernote({
    height: 300,
    callbacks: {
        onImageUpload: function(files) {
            let reader = new FileReader();
            reader.onload = function(e) {
                // Menyisipkan gambar dengan batas maksimal lebar 100%
                $('#description').summernote('insertImage', e.target.result, function($image) {
                    $image.css('max-width', '100%');
                    $image.css('border-radius', '5px');
                });
            };
            reader.readAsDataURL(files[0]);
        }
    }
});

