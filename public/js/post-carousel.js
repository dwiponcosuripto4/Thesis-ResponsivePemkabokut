// Convert description images to carousel on mobile
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 768) {
        const description = document.querySelector('.description');
        if (!description) return;

        // Find all images in description (excluding images already inside figures)
        const allImages = description.querySelectorAll('img');
        
        if (allImages.length === 0) return;

        // Collect unique image sources (avoid duplicates)
        let imageSources = [];
        let processedImages = new Set();
        
        allImages.forEach(img => {
            // Only add if not already processed
            if (!processedImages.has(img.src)) {
                imageSources.push(img.src);
                processedImages.add(img.src);
            }
        });

        if (imageSources.length === 0) return;

        // Create carousel HTML
        let carouselHTML = '<div class="description-image-carousel">';
        
        // Counter
        if (imageSources.length > 1) {
            carouselHTML += `<div class="description-carousel-counter">1 / ${imageSources.length}</div>`;
        }
        
        // Navigation arrows
        if (imageSources.length > 1) {
            carouselHTML += '<button class="description-carousel-arrow prev">‹</button>';
            carouselHTML += '<button class="description-carousel-arrow next">›</button>';
        }
        
        carouselHTML += '<div class="description-carousel-slides">';
        
        imageSources.forEach(src => {
            carouselHTML += `
                <div class="description-carousel-slide">
                    <img src="${src}" alt="Post Image">
                </div>
            `;
        });
        
        carouselHTML += '</div>';
        
        // Add indicators
        if (imageSources.length > 1) {
            carouselHTML += '<div class="description-carousel-indicators">';
            imageSources.forEach((src, index) => {
                carouselHTML += `<div class="description-carousel-indicator ${index === 0 ? 'active' : ''}" data-slide="${index}"></div>`;
            });
            carouselHTML += '</div>';
        }
        
        carouselHTML += '</div>';

        // Insert carousel at the beginning of description
        description.insertAdjacentHTML('afterbegin', carouselHTML);

        // Create lightbox for image zoom
        const lightboxHTML = `
            <div class="image-lightbox">
                <button class="image-lightbox-close">×</button>
                <img src="" alt="Zoomed Image">
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', lightboxHTML);

        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelector('.description-carousel-slides');
        const indicators = document.querySelectorAll('.description-carousel-indicator');
        const counter = document.querySelector('.description-carousel-counter');
        const totalSlides = imageSources.length;

        function goToSlide(index) {
            currentSlide = index;
            slides.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update indicators
            indicators.forEach((indicator, i) => {
                if (i === currentSlide) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
            
            // Update counter
            if (counter) {
                counter.textContent = `${currentSlide + 1} / ${totalSlides}`;
            }
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }

        // Auto-play every 4 seconds
        let autoPlayInterval = setInterval(nextSlide, 4000);

        // Navigation arrows
        const prevBtn = document.querySelector('.description-carousel-arrow.prev');
        const nextBtn = document.querySelector('.description-carousel-arrow.next');

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                clearInterval(autoPlayInterval);
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                goToSlide(currentSlide);
                autoPlayInterval = setInterval(nextSlide, 4000);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                clearInterval(autoPlayInterval);
                nextSlide();
                autoPlayInterval = setInterval(nextSlide, 4000);
            });
        }

        // Click indicators
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                clearInterval(autoPlayInterval);
                goToSlide(index);
                autoPlayInterval = setInterval(nextSlide, 4000);
            });
        });

        // Touch swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        const carousel = document.querySelector('.description-image-carousel');
        
        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                // Swipe left - next
                clearInterval(autoPlayInterval);
                nextSlide();
                autoPlayInterval = setInterval(nextSlide, 4000);
            }
            if (touchEndX > touchStartX + 50) {
                // Swipe right - prev
                clearInterval(autoPlayInterval);
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                goToSlide(currentSlide);
                autoPlayInterval = setInterval(nextSlide, 4000);
            }
        }

        // Pause on hover/touch
        carousel.addEventListener('mouseenter', () => {
            clearInterval(autoPlayInterval);
        });

        carousel.addEventListener('mouseleave', () => {
            autoPlayInterval = setInterval(nextSlide, 4000);
        });

        // Image lightbox functionality
        const lightbox = document.querySelector('.image-lightbox');
        const lightboxImg = lightbox.querySelector('img');
        const lightboxClose = lightbox.querySelector('.image-lightbox-close');
        const carouselImages = document.querySelectorAll('.description-carousel-slide img');

        // Click image to zoom
        carouselImages.forEach(img => {
            img.addEventListener('click', () => {
                lightboxImg.src = img.src;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent scroll
            });
        });

        // Close lightbox
        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = ''; // Restore scroll
        }

        lightboxClose.addEventListener('click', closeLightbox);

        // Close on background click
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                closeLightbox();
            }
        });
    }
});
