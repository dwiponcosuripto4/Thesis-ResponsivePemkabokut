@extends('layout')

@section('content')
    <section class="article-section" style="margin-top: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-header">
                        <h2 class="section-title">Daftar Artikel</h2>
                    </div>

                    <div id="articles-container">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <a href="{{ url('post/show/' . $post->id) }}" class="article-card"
                                        style="text-decoration:none; color:inherit;">
                                        <div class="position-relative">
                                            @php
                                                $images = json_decode($post->image);
                                                $firstImage = $images ? $images[0] : null;
                                            @endphp

                                            @if ($firstImage)
                                                @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                                    <img src="{{ $firstImage }}" class="article-image"
                                                        alt="{{ $post->title }}">
                                                @else
                                                    <img src="{{ asset('storage/' . $firstImage) }}" class="article-image"
                                                        alt="{{ $post->title }}">
                                                @endif
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" class="article-image"
                                                    alt="No Image">
                                            @endif

                                            <span class="article-category">
                                                @if ($post->headline)
                                                    {{ $post->headline->title }}
                                                @elseif($post->category)
                                                    {{ $post->category->title }}
                                                @else
                                                    Umum
                                                @endif
                                            </span>
                                        </div>

                                        <div class="article-content">
                                            <h5 class="article-title">{{ $post->title }}</h5>
                                            <div class="article-meta">
                                                <i class="bi bi-calendar"></i> {{ $post->published_at->format('d M Y') }}
                                                <span class="mx-2">•</span>
                                                <i class="bi bi-person"></i>
                                                {{ $post->user ? $post->user->name : 'Admin' }}
                                                <span class="mx-2">•</span>
                                                <i class="bi bi-eye"></i> {{ $post->views ?? 0 }}
                                            </div>
                                            <p class="article-excerpt">
                                                {{ Str::limit(strip_tags($post->description), 150, '...') }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($posts->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links() }}
                        </div>
                    @endif

                    @if ($posts->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-file-earmark-text" style="font-size: 3rem; color: #dee2e6;"></i>
                            <h4 class="mt-3 text-muted">Tidak ada artikel</h4>
                            <p class="text-muted">Belum ada artikel untuk kategori ini.</p>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="category-sidebar">
                        <div class="section-header">
                            <h2 class="section-title">Kategori Artikel</h2>
                        </div>

                        @foreach ($categories as $category)
                            <a href="javascript:void(0)" class="category-item" data-type="category"
                                data-id="{{ $category->id }}">
                                <span class="category-name">{{ $category->title }}</span>
                                <span class="category-count">{{ $category->posts_count ?? 0 }}</span>
                            </a>
                        @endforeach

                        @foreach ($headlines as $headline)
                            <a href="javascript:void(0)" class="category-item" data-type="headline"
                                data-id="{{ $headline->id }}">
                                <span class="category-name">{{ $headline->title }}</span>
                                <span class="category-count">{{ $headline->posts_count ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="{{ asset('css/headline/show.css') }}">
    <script src="{{ asset('js/headline/show.js') }}"></script>
@endpush
