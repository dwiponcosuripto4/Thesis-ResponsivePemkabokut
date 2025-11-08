@extends('layout')

@section('content')
    {{-- Detail Post --}}
    <section id="detail" style="padding-top: 100px; width: 100vw; margin-left: calc(-50vw + 50%);">
        <div class="container-fluid col-xxl-12 py-3" id="main-container">
            <div class="row justify-content-between">
                <div class="col-lg-8 col-md-12 col-sm-12 col-12 post-section">
                    <article class="post-content bg-white text-left shadow-sm mb-4">
                        @if ($post->image)
                            @php
                                $images = json_decode($post->image);
                                $firstImage = $images ? $images[0] : null;
                            @endphp
                            @if ($firstImage)
                                @php
                                    $isExternalImage = Str::startsWith($firstImage, ['http://', 'https://']);
                                @endphp
                                <img src="{{ $isExternalImage ? $firstImage : asset('storage/' . $firstImage) }}"
                                    alt="{{ $post->title }}"
                                    style="width: 100%; height: 400px; object-fit: cover; display: block; margin: 0; padding: 0; border-radius: 10px 10px 0 0;">
                            @endif
                        @endif
                        <div class="p-4">
                            <p class="mb-4">
                                <a href="/" class="text-decoration-none text-dark">Beranda</a> /
                                @if ($post->category)
                                    <a href="{{ route('headline.show', $post->category->id) }}"
                                        class="text-decoration-none text-dark">{{ $post->category->title }}</a> /
                                @endif
                                @if ($post->headline)
                                    <a href="{{ route('headline.show', $post->headline->id) }}"
                                        class="text-decoration-none text-dark">{{ $post->headline->title }}</a> /
                                @endif
                                {{ $post->title }}
                            </p>

                            <h3 class="fw-bold mb-3">{{ $post->title }}</h3>
                            @if ($post->headline)
                                <p class="mb-3">
                                    @if ($post->published_at)
                                        Published on {{ $post->published_at->format('d M Y, H:i') }} WIB
                                    @else
                                        Tanggal tidak tersedia
                                    @endif
                                </p>
                            @endif

                            <div class="description mt-4" style="overflow: hidden; text-align: justify;">
                                {!! $post->description !!}
                            </div>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 col-12 related-news-section mt-4 mt-lg-0">
                    <div class="related-news bg-white border shadow-sm p-3 mb-4" style="border-radius: 10px;">
                        <div class="header bg-primary text-white p-2 text-center"
                            style="border-radius: 10px; margin-bottom: 20px">
                            Pengumuman
                        </div>
                        <div class="body">
                            @forelse($documents->take(5) as $index => $document)
                                <a href="{{ route('document.show', $document->id) }}" class="text-decoration-none">
                                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #e9ecef;">
                                        <h6 class="text-dark post-title {{ $index === 0 ? 'fw-bold' : '' }}"
                                            style="font-size: 15px;">
                                            {{ $document->title }}
                                        </h6>
                                        <p class="text-muted" style="font-size: 11px; margin-top: 5px;">
                                            {{ $document->created_at ? $document->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-muted text-center" style="font-size: 14px;">Belum ada pengumuman</p>
                            @endforelse

                            @if ($documents->count() > 0)
                                <div class="text-center mt-3">
                                    <a href="{{ route('document.data') }}" class="btn btn-outline-primary btn-sm">
                                        Lihat Semua <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="related-news bg-white border shadow-sm p-3" style="border-radius: 10px;">
                        <div class="header bg-primary text-white p-2 text-center"
                            style="border-radius: 10px; margin-bottom: 20px">
                            Berita Lainnya
                        </div>
                        <div class="body">
                            @foreach (\App\Models\Post::where('id', '!=', $post->id)->where('draft', false)->whereNotNull('headline_id')->orderBy('id', 'desc')->take(5)->get() as $otherPost)
                                <a href="/post/show/{{ $otherPost->id }}" class="text-decoration-none">
                                    <div class="d-flex mb-3">
                                        @php
                                            $images = json_decode($otherPost->image);
                                            $firstImage = $images ? $images[0] : null;
                                        @endphp

                                        @if ($firstImage && Str::startsWith($firstImage, ['http://', 'https://']))
                                            <img src="{{ $firstImage }}" alt="{{ $otherPost->title }}"
                                                class="related-news-image thumbnail-blur">
                                        @else
                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $otherPost->title }}"
                                                class="related-news-image thumbnail-blur">
                                        @endif

                                        <div class="ms-3">
                                            <h6 class="text-dark post-title">{{ $otherPost->title }}</h6>
                                            <p class="text-muted" style="font-size: 12px;">
                                                {{ $otherPost->published_at ? $otherPost->published_at->format('d M Y') : 'Tanggal tidak tersedia' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <link rel="stylesheet" href="{{ asset('css/post/show.css') }}">
    {{-- CAROUSEL SCRIPT DISABLED --}}
    {{-- <script src="{{ asset('js/post-carousel.js') }}"></script> --}}

    @push('styles')
        <style>
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

            .description img {
                cursor: pointer;
                transition: opacity 0.2s;
            }

            .description img:hover {
                opacity: 0.9;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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
                    // Check if clicked element is an image inside description
                    if (e.target.matches('.description img')) {
                        e.preventDefault(); // Prevent default link behavior
                        e.stopPropagation(); // Stop event from bubbling up

                        const img = e.target;
                        lightboxImg.src = img.src;
                        lightboxImg.alt = img.alt;
                        lightbox.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                }, true); // Use capture phase to catch event before link

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
        </script>
    @endpush
@endsection
