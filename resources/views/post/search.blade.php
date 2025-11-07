@extends('layout')

@section('content')
    {{-- Section Search Results --}}
    <section id="search-results-section" class="py-4" style="min-height: 100vh;">
        <div class="container" style="padding-top: 100px;">
            <h2 class="mb-4 text-center">Menampilkan hasil pencarian "{{ $searchQuery }}"</h2>

            @if ($results->isEmpty())
                <div class="alert alert-warning text-center">
                    Tidak ada hasil yang sesuai dengan kata kunci "{{ $searchQuery }}".
                </div>
            @else
                <h3 class="mb-4">Hasil:</h3>
                <div class="row">
                    @foreach ($results as $result)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    @if ($result instanceof App\Models\Post)
                                        @php
                                            $images = json_decode($result->image);
                                            $firstImage = $images ? $images[0] : null;
                                        @endphp

                                        @if ($firstImage)
                                            @if (Str::startsWith($firstImage, ['http://', 'https://']))
                                                <img src="{{ $firstImage }}" class="img-fluid mb-3" alt="Gambar Post"
                                                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                            @else
                                                <img src="{{ asset('storage/' . $firstImage) }}" class="img-fluid mb-3"
                                                    alt="Gambar Post"
                                                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                            @endif
                                        @else
                                            <img src="{{ asset('images/placeholder.png') }}" class="img-fluid mb-3"
                                                alt="Placeholder Image"
                                                style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                                        @endif

                                        <h5 class="card-title">{{ Str::limit($result->title, 50) }}</h5>
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-calendar"></i>
                                            @if ($result->published_at)
                                                {{ $result->published_at->format('d M Y') }}
                                            @else
                                                Tanggal tidak tersedia
                                            @endif
                                            &nbsp;&nbsp;<i class="bi bi-person"></i> Admin
                                            &nbsp;&nbsp;<i class="bi bi-eye"></i> {{ $result->views }}
                                        </p>
                                        <p class="card-text">{{ Str::limit(strip_tags($result->description), 100, '...') }}
                                        </p>
                                        <a href="/post/show/{{ $result->id }}" class="btn btn-primary">Selengkapnya</a>
                                    @elseif ($result instanceof App\Models\Document)
                                        <img src="{{ asset('/icons/dokumen.jpg') }}" class="img-fluid mb-3"
                                            alt="Document Image"
                                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">

                                        <h5 class="card-title">{{ Str::limit($result->title, 150) }}</h5>

                                        <p class="text-muted mb-2">
                                            <i class="bi bi-calendar"></i>
                                            @if ($result->created_at)
                                                {{ $result->created_at->format('d M Y') }}
                                            @else
                                                Tanggal tidak tersedia
                                            @endif
                                        </p>

                                        <p class="card-text">
                                        <ul class="list-unstyled">
                                            @foreach ($result->file as $file)
                                                <li class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>{{ basename($file->file_path) }}</span>
                                                    <a href="{{ asset('storage/' . $file->file_path) }}"
                                                        class="btn btn-primary btn-sm" download>
                                                        <i class="bi bi-download"></i> Download
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        </p>

                                        <a href="/data/show/{{ $result->id }}" class="btn btn-primary">Selengkapnya</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
