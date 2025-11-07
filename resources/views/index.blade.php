@extends('layout')

@section('content')
    <!-- Search Form Section -->
    <section id="search-section" style="position: relative; margin: 0; padding: 0; width: 100vw; overflow: hidden;">
        <div id="heroCarousel" class="owl-carousel owl-theme"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
            <div class="item">
                <img src="{{ asset('images/kantor.jpg') }}" class="d-block w-100" style="height: 100vh; object-fit: cover;"
                    loading="eager">
            </div>
            <div class="item">
                <img src="{{ asset('images/Perjaya.jpg') }}" class="d-block w-100" style="height: 100vh; object-fit: cover;"
                    loading="lazy">
            </div>
            <div class="item">
                <img src="{{ asset('images/Bendungan-Perjaya.jpg') }}" class="d-block w-100"
                    style="height: 100vh; object-fit: cover;" loading="lazy">
            </div>
            <div class="item">
                <img src="{{ asset('images/sawah.jpg') }}" class="d-block w-100" style="height: 100vh; object-fit: cover;"
                    loading="lazy">
            </div>
        </div>

        <div
            style="background: radial-gradient(110% 300% at 2% 0%, #00276aff 5%, rgba(0, 0, 0, 0.200) 62%);
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
        </div>

        <div class="container-fluid d-flex flex-column justify-content-center align-items-center"
            style="height: 100%; position: relative; z-index: 2; margin: 0; width: 100%;">
            <h1 id="welcomePopup" class="text-white text-center fw-bold text-uppercase mb-3 popup-scale"
                style="transform: translateY(60px);">
                <span class="welcome-line-1">Selamat Datang</span>
                <span class="welcome-line-2">Pemerintah Kabupaten OKU TIMUR</span>
                <span class="welcome-line-mobile">Pemerintah</span>
                <span class="welcome-line-mobile">Kabupaten OKU TIMUR</span>
            </h1>
            <p id="infoPopup" class="text-white fs-5 text-center mb-4 popup-left" style="transform: translateY(60px);">
                Temukan informasi publik terkini dari Kabupaten OKU TIMUR
            </p>

            <form class="search-form d-flex justify-content-between align-items-center" method="GET"
                action="{{ route('post.search') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="query" class="form-control border-0"
                        placeholder="Cari informasi, berita, dan dokumen disini...." aria-label="Search">
                </div>
                <button class="btn btn-primary btn-search" type="submit">Cari</button>
            </form>

            <!-- Icon Section -->
            <div class="icon-section d-flex flex-wrap justify-content-center rounded-3 py-3 mt-3" id="iconAccordion">
                @foreach ($icons as $icon)
                    <div class="icon-container d-flex flex-column gap-2 justify-content-center align-items-center">
                        <div class="card bg-opacity-60 text-center">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->title }}"
                                    class="img-fluid submenu-toggle" data-icon-id="{{ $icon->id }}">
                            </div>
                        </div>
                        <div class="portal-title">
                            <p class="text-center text-white">{{ $icon->title }}</p>
                        </div>
                        <!-- Portal Submenu Collapse -->
                        <div id="iconMenu{{ $icon->id }}" class="submenu-collapse" style="z-index: 9999;">
                            <ul>
                                @foreach ($icon->dropdowns as $dropdown)
                                    <li style="display: flex; align-items: center; gap: 10px; padding: 8px 0;">
                                        @if ($dropdown->icon_dropdown)
                                            <img src="{{ asset('storage/' . $dropdown->icon_dropdown) }}" alt="icon"
                                                style="width: 28px; height: 28px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                        <a href="{{ $dropdown->link }}" target="_blank"
                                            style="flex: 1;">{{ $dropdown->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

                <!-- UMKM Icon Menu -->
                @if (!$umkmSettings['hide_menu'])
                    <div class="icon-container d-flex flex-column gap-2 justify-content-center align-items-center">
                        <div class="card bg-opacity-60 text-center">
                            <div class="card-body">
                                <img src="{{ asset('icons/market.png') }}" alt="UMKM" class="img-fluid submenu-toggle"
                                    data-icon-id="umkm">
                            </div>
                        </div>
                        <div class="portal-title">
                            <p class="text-center text-white">UMKM</p>
                        </div>
                        <!-- UMKM Submenu Collapse -->
                        <div id="iconMenuumkm" class="submenu-collapse">
                            <ul>
                                @if (!$umkmSettings['hide_registration'])
                                    <li style="display: flex; align-items: center; gap: 10px; padding: 8px 0;">
                                        <div
                                            style="width: 28px; height: 28px; background: linear-gradient(45deg, #007bff, #0056b3); border-radius: 4px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-plus-circle" style="color: white; font-size: 14px;"></i>
                                        </div>
                                        <a href="{{ route('umkm.index') }}" target="_blank" style="flex: 1;">Pendaftaran
                                            UMKM</a>
                                    </li>
                                @endif
                                @if ($approvedBusinesses->isEmpty())
                                    <li style="padding: 20px; text-align: center; border: none;">
                                        <div style="color: #6c757d; font-style: italic;">
                                            <i class="bi bi-info-circle"
                                                style="font-size: 18px; margin-bottom: 8px; display: block;"></i>
                                            <div style="font-size: 14px;">Belum ada UMKM yang terdaftar</div>
                                            <div style="font-size: 12px; margin-top: 4px;">Silakan daftarkan bisnis Anda
                                                @if (!$umkmSettings['hide_registration'])
                                                    menggunakan tombol "Pendaftaran UMKM" di atas
                                                @else
                                                    dengan menghubungi admin
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    @foreach ($approvedBusinesses as $index => $business)
                                        <li style="display: flex; align-items: center; gap: 10px; padding: 8px 0;">
                                            @php
                                                $businessPhoto = $business->foto;
                                            @endphp

                                            @if ($businessPhoto)
                                                @if (Str::startsWith($businessPhoto, ['http://', 'https://']))
                                                    <img src="{{ $businessPhoto }}" alt="{{ $business->nama }}"
                                                        style="width: 28px; height: 28px; object-fit: cover; border-radius: 4px; flex-shrink: 0;">
                                                @else
                                                    <img src="{{ asset('storage/' . $businessPhoto) }}"
                                                        alt="{{ $business->nama }}"
                                                        style="width: 28px; height: 28px; object-fit: cover; border-radius: 4px; flex-shrink: 0;">
                                                @endif
                                            @else
                                                <div
                                                    style="width: 28px; height: 28px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 4px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-building"
                                                        style="color: #6c757d; font-size: 14px;"></i>
                                                </div>
                                            @endif

                                            <a href="{{ route('umkm.show', $business->id) }}" target="_blank"
                                                @if ($index === 0) class="newest-business" @endif
                                                style="flex: 1;">
                                                {{ $business->nama }}
                                                @if ($index === 0)
                                                    <span
                                                        style="font-size: 9px; background: linear-gradient(45deg, #28a745, #20c997); color: white; padding: 2px 5px; border-radius: 10px; margin-left: 3px; font-weight: bold; text-transform: uppercase;">NEW</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <div class="social-icons-index d-block d-lg-none">
                <a href="https://www.facebook.com/diskominfo.okutimur.33?mibextid=ZbWKwL" target="_blank">
                    <img src="{{ URL::asset('/images/facebook.png') }}" alt="Facebook">
                </a>
                <a href="https://www.tiktok.com/@diskominfokabokutimur?_t=8pSKpeZFB1m&_r=1" target="_blank">
                    <img src="{{ URL::asset('/images/tiktok.png') }}" alt="Tiktok">
                </a>
                <a href="https://www.instagram.com/diskominfo.okutimur?igsh=dWdrenR0Y2Z4dHgy" target="_blank">
                    <img src="{{ URL::asset('/images/instagram.png') }}" alt="Instagram">
                </a>
                <a href="https://youtube.com/@diskominfookutimur9504?si=Ke9dyfDnzkx-pAVN" target="_blank">
                    <img src="{{ URL::asset('/images/youtube.png') }}" alt="YouTube">
                </a>
            </div>
        </div>
    </section>

    {{-- Berita dan Pengumuman --}}
    <section id="pengumuman-section" style="background-image: url('images/cover.png')">
        <div class="container pengumuman-container d-flex justify-content-center" style="padding-top: 40px;">
            <div class="col-md-8 berita-terkini-wrapper">
                <div class="berita-terkini-header">
                    <h2 class="text-dark berita-title-text">Berita Terkini</h2>

                    <div class="title-underline">
                        <div class="underline-thick"></div>
                        <div class="underline-thin"></div>
                    </div>

                    <div class="carousel-nav-buttons">
                        <button class="owl-prev btn btn-light">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="owl-next btn btn-light ms-2">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="berita-carousel-container">
                    <div id="latestArticle" class="owl-carousel owl-theme">
                        @foreach ($posts->where('draft', false)->take(4) as $post)
                            <div class="item">
                                <a href="/post/show/{{ $post->id }}" class="text-decoration-none"
                                    style="display: block;">
                                    <article class="berita-article" style="cursor: pointer;">
                                        @php
                                            $images = json_decode($post->image);
                                            $firstImage = $images ? $images[0] : null;
                                        @endphp

                                        @if ($firstImage)
                                            @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                                <img src="{{ $firstImage }}" class="berita-image"
                                                    alt="{{ $post->title }}">
                                            @else
                                                <img src="{{ asset('storage/' . $firstImage) }}" class="berita-image"
                                                    alt="{{ $post->title }}">
                                            @endif
                                        @else
                                            <img src="{{ asset('images/placeholder.png') }}" class="berita-image"
                                                alt="Placeholder">
                                        @endif

                                        <div class="berita-content">
                                            <h3 class="berita-title title-clamp">{{ $post->title }}</h3>

                                            <div class="berita-meta">
                                                <span class="meta-item">
                                                    <i class="bi bi-calendar"></i>
                                                    @if ($post->published_at)
                                                        {{ $post->published_at->format('d M Y') }}
                                                    @else
                                                        Tanggal tidak tersedia
                                                    @endif
                                                </span>
                                                <span class="meta-item">
                                                    <i class="bi bi-person"></i>
                                                    {{ $post->user ? $post->user->name : 'User' }}
                                                </span>
                                                <span class="meta-item">
                                                    <i class="bi bi-eye"></i>
                                                    {{ $post->views }}
                                                </span>
                                            </div>

                                            <p class="berita-description description-clamp">
                                                {{ Str::limit(html_entity_decode(strip_tags($post->description)), 200, '...') }}
                                            </p>

                                            <span class="berita-link">
                                                Selengkapnya <i class="bi bi-arrow-right"></i>
                                            </span>
                                        </div>
                                    </article>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4 pengumuman-col">
                <div class="pengumuman-header">
                    <h5 class="mb-3" style="font-weight: 600; font-size: 22px; margin-top: -9.5px;">
                        Pengumuman</h5>

                    <div class="pengumuman-underline">
                        <div class="underline-thick"></div>
                        <div class="underline-thin"></div>
                    </div>
                </div>
                <div class="pengumuman-inner">
                    <div class="list-group">
                        @foreach ($documents->sortByDesc('date')->take(5) as $index => $document)
                            <a href="{{ route('document.show', $document->id) }}"
                                class="list-group-item list-group-item-action {{ $index === 0 ? 'newest-document' : '' }}"
                                style="border-left: 4px solid {{ $index === 0 ? '#ffffff' : '#2F4F7F' }}; padding: 15px 20px;">
                                <span style="color: #333; font-size: 16px; {{ $index === 0 ? 'font-weight: 600;' : '' }}">
                                    {{ $document->title }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Headline --}}
    <section id="headline" class="py-4" style="background-image: url('images/cover.png');">
        <div class="headline-container container">
            <h2 class="mb-4" style="font-family: 'Roboto', serif; font-size: 23px;">Berita Lainnya</h2>
            <div class="mb-2 d-flex align-items-center" style="margin-top: -15px">
                <div style="width: 50px; height: 6px; background-color: #2F4F7F;"></div>
                <div style="flex-grow: 1; height: 2px; background-color: #2F4F7F;"></div>
            </div>
            <div class="row" style="margin-top: 20px">
                @foreach ($posts->where('draft', false)->whereNotNull('headline_id')->sortByDesc('id')->take(6) as $post)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <a href="/post/show/{{ $post->id }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm">
                                @php
                                    $images = json_decode($post->image);
                                    $firstImage = $images ? $images[0] : null;
                                @endphp

                                @if ($firstImage)
                                    @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                        <img src="{{ $firstImage }}" class="img-fluid" alt="Gambar Post"
                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid"
                                            alt="Gambar Post"
                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                @else
                                    <img src="{{ asset('images/placeholder.png') }}" class="img-fluid"
                                        alt="Placeholder Image"
                                        style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px;">
                                @endif

                                <div class="card-body p-3"
                                    style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(0, 0, 0, 0.7); border-radius: 0 0 10px 10px;">
                                    <h5 class="card-title text-white" style="font-size: 16px;">{{ $post->title }}</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-calendar"></i>
                                            @if ($post->published_at)
                                                Published on {{ $post->published_at->format('d M Y') }}
                                            @endif
                                        </span>
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-person"></i> {{ $post->user ? $post->user->name : 'User' }}
                                            &nbsp;
                                        </span>
                                        <span class="text-white-50" style="font-size: 12px;">
                                            <i class="bi bi-eye"></i> {{ $post->views }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('headline.show', ['id' => $post->headline_id]) }}" class="btn btn-outline-primary">
                    Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    {{-- Headline --}}

    {{-- Info Section --}}
    <section id="info-section" class="py-5" style="background-color: #3d4148;">
        <div class="container" style="max-width: 1200px; padding-left: 15px; padding-right: 15px;">
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <h5 class="info-title mb-3">Pengumuman</h5>
                    <div class="mb-3 d-flex align-items-center">
                        <div style="width: 50px; height: 4px; background-color: #debe5a;"></div>
                        <div style="flex-grow: 1; height: 2px; background-color: #debe5a;"></div>
                    </div>
                    <div class="info-list">
                        @forelse($documents->take(5) as $document)
                            <a href="{{ route('document.show', $document->id) }}" class="info-item">
                                {{ Str::limit($document->title, 60) }}
                            </a>
                        @empty
                            <p class="text-muted small">Belum ada pengumuman</p>
                        @endforelse
                    </div>
                    <a href="{{ route('document.data') }}" class="btn-lihat-lainnya mt-3">
                        Lihat Lainnya <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <h5 class="info-title mb-3">Berita Daerah</h5>
                    <div class="mb-3 d-flex align-items-center">
                        <div style="width: 50px; height: 4px; background-color: #debe5a;"></div>
                        <div style="flex-grow: 1; height: 2px; background-color: #debe5a;"></div>
                    </div>
                    <div class="info-list">
                        @forelse($beritaDaerah as $post)
                            <a href="/post/show/{{ $post->id }}" class="info-item">
                                {{ Str::limit($post->title, 60) }}
                            </a>
                        @empty
                            <p class="text-muted small">Belum ada berita daerah</p>
                        @endforelse
                    </div>
                    @if ($beritaDaerah->isNotEmpty())
                        <a href="{{ route('headline.show', 3) }}" class="btn-lihat-lainnya mt-3">
                            Lihat Lainnya <i class="bi bi-arrow-right"></i>
                        </a>
                    @endif
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <h5 class="info-title mb-3">Berita Umum</h5>
                    <div class="mb-3 d-flex align-items-center">
                        <div style="width: 50px; height: 4px; background-color: #debe5a;"></div>
                        <div style="flex-grow: 1; height: 2px; background-color: #debe5a;"></div>
                    </div>
                    <div class="info-list">
                        @forelse($beritaUmum as $post)
                            <a href="/post/show/{{ $post->id }}" class="info-item">
                                {{ Str::limit($post->title, 60) }}
                            </a>
                        @empty
                            <p class="text-muted small">Belum ada berita umum</p>
                        @endforelse
                    </div>
                    @if ($beritaUmum->isNotEmpty())
                        <a href="{{ route('headline.show', 4) }}" class="btn-lihat-lainnya mt-3">
                            Lihat Lainnya <i class="bi bi-arrow-right"></i>
                        </a>
                    @endif
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <h5 class="info-title mb-3">Nomor Penting</h5>
                    <div class="mb-3 d-flex align-items-center">
                        <div style="width: 50px; height: 4px; background-color: #debe5a;"></div>
                        <div style="flex-grow: 1; height: 2px; background-color: #debe5a;"></div>
                    </div>
                    <div class="info-list">
                        <div class="contact-item">
                            <span>Pemda : (0735)481035</span>
                        </div>
                        <div class="contact-item">
                            <span>Polres : (0735)481613</span>
                        </div>
                        <div class="contact-item">
                            <span>Pemadam Kebakaran : (0735)481113</span>
                        </div>
                        <div class="contact-item">
                            <span>BPBD : (0735)481832</span>
                        </div>
                        <div class="contact-item">
                            <span>PLN : (0735)481874</span>
                        </div>
                        <div class="contact-item">
                            <span>RSUD Martapura : (0735)481004</span>
                        </div>
                        <div class="contact-item">
                            <span>RSUD Belitang : (0735)451815</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/index.js') }}"></script>
@endsection
