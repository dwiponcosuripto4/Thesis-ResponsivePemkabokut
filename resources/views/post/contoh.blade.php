@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if ($post->image)
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            @endif

            <div class="p-8">
                <div class="mb-6">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                    <div class="flex items-center text-gray-600 text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ $post->published_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>

                <div class="prose prose-lg max-w-none text-gray-800">
                    {!! $post->content !!}
                </div>
            </div>
        </article>

        <div class="mt-8">
            <a href="{{ route('posts.index') }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>

    @push('styles')
        <style>
            .prose img {
                max-width: 100%;
                height: auto;
                border-radius: 0.5rem;
                margin: 1.5rem 0;
                display: none;
            }

            .prose h1,
            .prose h2,
            .prose h3 {
                font-weight: 700;
                margin-top: 2rem;
                margin-bottom: 1rem;
            }

            .prose h1 {
                font-size: 2rem;
            }

            .prose h2 {
                font-size: 1.5rem;
            }

            .prose h3 {
                font-size: 1.25rem;
            }

            .prose p {
                margin-bottom: 1rem;
                line-height: 1.75;
            }

            .prose ul,
            .prose ol {
                margin-left: 1.5rem;
                margin-bottom: 1rem;
            }

            .prose ul {
                list-style-type: disc;
            }

            .prose ol {
                list-style-type: decimal;
            }

            .prose li {
                margin-bottom: 0.5rem;
            }

            .prose blockquote {
                border-left: 4px solid #3b82f6;
                padding-left: 1rem;
                font-style: italic;
                color: #4b5563;
                margin: 1.5rem 0;
            }

            .image-gallery {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin: 1.5rem 0;
            }

            .image-gallery img {
                margin-bottom: 0rem;
                margin-top: -3rem;
                border-radius: 0.5rem;
                display: block;
                cursor: pointer;
                transition: transform 0.2s, opacity 0.2s;
            }

            .image-gallery img:hover {
                opacity: 0.9;
                transform: scale(1.02);
            }

            .image-gallery.single-image img {
                margin-top: 0rem;
                width: auto;
                height: auto;
                max-width: 100%;
            }

            .image-gallery.two-images img {
                margin-top: 0rem;
                width: 533px;
                height: 299px;
                max-width: calc(50% - 6px);
                object-fit: cover;
            }

            .image-gallery.three-images img {
                margin-top: 0rem;
                width: 353px;
                height: 199px;
                max-width: calc(33.333% - 8px);
                object-fit: cover;
            }

            .image-gallery.multi-row {
                margin-top: 4rem;
                flex-wrap: wrap;
            }

            .image-gallery .image-row {
                display: flex;
                gap: 12px;
                width: 100%;
                margin-bottom: 45px;
            }

            .image-gallery .image-row:last-child {
                margin-bottom: 0;
            }

            .image-gallery .image-row.three-cols img {
                width: 353px;
                height: 199px;
                max-width: calc(33.333% - 8px);
                object-fit: cover;
            }

            .image-gallery .image-row.single-col img {
                width: auto;
                height: auto;
                max-width: 100%;
            }

            .image-gallery .image-row.two-cols img {
                width: 533px;
                height: 299px;
                max-width: calc(50% - 6px);
                object-fit: cover;
            }

            .lightbox {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                z-index: 9999;
                justify-content: center;
                align-items: center;
                cursor: pointer;
            }

            .lightbox.active {
                display: flex;
            }

            .lightbox img {
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                border-radius: 0.5rem;
                cursor: default;
            }

            .lightbox-close {
                position: absolute;
                top: 20px;
                right: 30px;
                font-size: 40px;
                color: white;
                cursor: pointer;
                z-index: 10000;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const contentDiv = document.querySelector('.prose');
                if (!contentDiv) return;

                const images = contentDiv.querySelectorAll('img');
                if (images.length === 0) return;

                const imageGroups = [];
                let currentGroup = [];

                images.forEach(img => {
                    img.style.display = 'none';
                    currentGroup.push(img);
                });

                if (currentGroup.length > 0) {
                    imageGroups.push(currentGroup);
                }

                const firstImage = images[0];
                const insertPoint = firstImage.parentElement;

                imageGroups.forEach(group => {
                    processImageGroup(group, insertPoint);
                });

                initLightbox();
            });

            function initLightbox() {
                const lightbox = document.createElement('div');
                lightbox.className = 'lightbox';
                lightbox.innerHTML = '<span class="lightbox-close">&times;</span><img src="" alt="">';
                document.body.appendChild(lightbox);

                const lightboxImg = lightbox.querySelector('img');
                const closeBtn = lightbox.querySelector('.lightbox-close');

                document.addEventListener('click', function(e) {
                    if (e.target.closest('.image-gallery img')) {
                        const img = e.target;
                        lightboxImg.src = img.src;
                        lightboxImg.alt = img.alt;
                        lightbox.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });

                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox || e.target === closeBtn) {
                        lightbox.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                        lightbox.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            }

            function processImageGroup(images, insertPoint) {
                const totalImages = images.length;

                if (totalImages === 1) {
                    createGallery(images, 'single-image', insertPoint);
                } else if (totalImages === 2) {
                    createGallery(images, 'two-images', insertPoint);
                } else if (totalImages === 3) {
                    createGallery(images, 'three-images', insertPoint);
                } else if (totalImages === 4) {
                    const firstThree = images.slice(0, 3);
                    const lastOne = images.slice(3, 4);
                    createFourImageGallery(firstThree, lastOne, insertPoint);
                } else {
                    const fullRows = Math.floor(totalImages / 3);
                    const remainder = totalImages % 3;

                    let processedImages = 0;

                    for (let i = 0; i < fullRows; i++) {
                        const rowImages = images.slice(processedImages, processedImages + 3);
                        createGalleryRow(rowImages, 'three-cols', insertPoint);
                        processedImages += 3;
                    }

                    if (remainder > 0) {
                        const remainingImages = images.slice(processedImages);
                        if (remainder === 1) {
                            createGalleryRow(remainingImages, 'single-col', insertPoint);
                        } else if (remainder === 2) {
                            createGalleryRow(remainingImages, 'two-cols', insertPoint);
                        }
                    }
                }
            }

            function createGallery(images, className, insertPoint) {
                const gallery = document.createElement('div');
                gallery.className = `image-gallery ${className}`;

                images.forEach(img => {
                    const newImg = img.cloneNode(true);
                    newImg.style.display = 'block';
                    gallery.appendChild(newImg);
                });

                insertPoint.parentNode.insertBefore(gallery, insertPoint.nextSibling);
            }

            function createGalleryRow(images, className, insertPoint) {
                const gallery = document.createElement('div');
                gallery.className = 'image-gallery multi-row';

                const row = document.createElement('div');
                row.className = `image-row ${className}`;

                images.forEach(img => {
                    const newImg = img.cloneNode(true);
                    newImg.style.display = 'block';
                    row.appendChild(newImg);
                });

                gallery.appendChild(row);
                insertPoint.parentNode.insertBefore(gallery, insertPoint.nextSibling);
            }

            function createFourImageGallery(firstThree, lastOne, insertPoint) {
                const gallery = document.createElement('div');
                gallery.className = 'image-gallery multi-row';

                const firstRow = document.createElement('div');
                firstRow.className = 'image-row three-cols';
                firstThree.forEach(img => {
                    const newImg = img.cloneNode(true);
                    newImg.style.display = 'block';
                    firstRow.appendChild(newImg);
                });

                const secondRow = document.createElement('div');
                secondRow.className = 'image-row single-col';
                lastOne.forEach(img => {
                    const newImg = img.cloneNode(true);
                    newImg.style.display = 'block';
                    secondRow.appendChild(newImg);
                });

                gallery.appendChild(firstRow);
                gallery.appendChild(secondRow);
                insertPoint.parentNode.insertBefore(gallery, insertPoint.nextSibling);
            }
        </script>
    @endpush
@endsection
