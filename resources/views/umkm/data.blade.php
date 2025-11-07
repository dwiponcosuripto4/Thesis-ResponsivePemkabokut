@extends('layout')

@section('content')
    <div class="container mt-5 umkm-container" style="min-height: 100vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Data UMKM</h2>
            <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Daftarkan UMKM
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($businesses as $index => $business)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="umkm-card card">
                        @php
                            $foto = is_array($business->foto) ? $business->foto[0] : $business->foto;
                        @endphp

                        @if ($foto)
                            <div class="umkm-card-background"
                                style="background-image: url('{{ asset('storage/' . $foto) }}')"></div>
                        @else
                            <div class="umkm-card-background no-image">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif

                        <div class="umkm-overlay">
                            <div class="umkm-badge">{{ $business->jenis }}</div>
                            <div class="umkm-title">{{ $business->nama }}</div>
                            <div class="umkm-desc">{{ Str::limit($business->deskripsi, 80, '...') }}</div>
                            <div class="umkm-actions">
                                <a href="{{ route('umkm.show', $business->id) }}" class="btn btn-detail">
                                    <i class="fas fa-eye"></i> Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-store"></i>
                        <h4 class="text-muted">Belum ada data UMKM</h4>
                        <p class="text-muted mb-3">Mulai daftarkan UMKM pertama Anda</p>
                        <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Daftarkan UMKM Sekarang
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/umkm/data.css') }}">
@endsection
