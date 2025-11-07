@extends('layout')

@section('title', 'Dokumen Publik')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/document/show.css') }}">
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Daftar Dokumen Publik
                        </li>
                    </ol>
                </nav>
                <h1 class="hero-title">{{ $document->title ?? 'Dokumen Perencanaan' }}</h1>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="table-container">
                @if ($document && $document->file->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No.</th>
                                    <th style="width: 10%">Tahun</th>
                                    <th style="width: 55%">Judul</th>
                                    <th style="width: 15%">Tanggal Upload</th>
                                    <th style="width: 15%" class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($document->file as $index => $file)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span
                                                class="year-badge">{{ \Carbon\Carbon::parse($file->file_date)->format('Y') }}</span>
                                        </td>
                                        <td><span class="doc-title">{{ $file->title ?? '-' }}</span></td>
                                        <td><span
                                                class="upload-date">{{ \Carbon\Carbon::parse($file->created_at)->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if (is_array($file->file_path) && count($file->file_path) > 0)
                                                @foreach ($file->file_path as $path)
                                                    <a href="{{ route('file.download', $file->id) }}"
                                                        class="download-btn mb-1">
                                                        <i class="bi bi-download"></i>
                                                        Download
                                                    </a>
                                                    @if (!$loop->last)
                                                        <br>
                                                    @endif
                                                @endforeach
                                            @elseif($file->file_path)
                                                <a href="{{ route('file.download', $file->id) }}" class="download-btn">
                                                    <i class="bi bi-download"></i>
                                                    Download
                                                </a>
                                            @else
                                                <span class="text-muted">No file available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @foreach ($document->file as $index => $file)
                        <div class="document-card">
                            <div class="card-header-mobile">
                                <span class="card-number">#{{ $index + 1 }}</span>
                                <span class="year-badge">{{ \Carbon\Carbon::parse($file->file_date)->format('Y') }}</span>
                            </div>
                            <div class="card-body-mobile">
                                <div class="doc-title">{{ $file->title ?? '-' }}</div>
                                <div class="upload-date">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>{{ \Carbon\Carbon::parse($file->created_at)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="card-footer-mobile">
                                @if (is_array($file->file_path) && count($file->file_path) > 0)
                                    @foreach ($file->file_path as $path)
                                        <a href="{{ route('file.download', $file->id) }}" class="download-btn">
                                            <i class="bi bi-download"></i>
                                            Download
                                        </a>
                                    @endforeach
                                @elseif($file->file_path)
                                    <a href="{{ route('file.download', $file->id) }}" class="download-btn">
                                        <i class="bi bi-download"></i>
                                        Download
                                    </a>
                                @else
                                    <span class="text-muted">No file available</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-data">
                        <i class="bi bi-file-earmark-text" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Tidak ada dokumen tersedia</h4>
                        <p>Belum ada dokumen yang diunggah untuk kategori ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
