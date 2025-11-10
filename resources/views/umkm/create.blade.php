@extends('layout')

@section('content')
    <div class="container mt-5" style="padding-top: 90px">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Daftarkan UMKM</h4>
                            <a href="{{ route('umkm.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama UMKM <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis Usaha <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis" name="jenis" required>
                                        <option value="">Pilih Jenis Usaha</option>
                                        <option value="Makanan dan Minuman"
                                            {{ old('jenis') == 'Makanan dan Minuman' ? 'selected' : '' }}>Makanan dan
                                            Minuman</option>
                                        <option value="Pakaian dan Aksesoris"
                                            {{ old('jenis') == 'Pakaian dan Aksesoris' ? 'selected' : '' }}>Pakaian dan
                                            Aksesoris</option>
                                        <option value="Jasa" {{ old('jenis') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                        <option value="Kerajinan Tangan"
                                            {{ old('jenis') == 'Kerajinan Tangan' ? 'selected' : '' }}>Kerajinan Tangan
                                        </option>
                                        <option value="Elektronik" {{ old('jenis') == 'Elektronik' ? 'selected' : '' }}>
                                            Elektronik</option>
                                        <option value="Kesehatan" {{ old('jenis') == 'Kesehatan' ? 'selected' : '' }}>
                                            Kesehatan</option>
                                        <option value="Transportasi"
                                            {{ old('jenis') == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                        <option value="Pendidikan" {{ old('jenis') == 'Pendidikan' ? 'selected' : '' }}>
                                            Pendidikan</option>
                                        <option value="Teknologi" {{ old('jenis') == 'Teknologi' ? 'selected' : '' }}>
                                            Teknologi</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="owner" class="form-label">Nama Pemilik <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="owner" name="owner"
                                        value="{{ old('owner') }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="input_url" class="form-label">Link Google Maps (Opsional)</label>
                                    <div class="input-group">
                                        <input type="url" class="form-control" id="input_url" name="input_url"
                                            value="{{ old('input_url') }}"
                                            placeholder="Contoh: https://maps.app.goo.gl/jJwhxr7QvHh5P3SVA atau https://www.google.com/maps/place/...">
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="previewBtn">Preview</button>
                                    </div>
                                    <small class="text-muted">
                                        <strong>Cara mendapat link:</strong><br>
                                        1. Buka Google Maps → 2. Cari lokasi usaha → 3. Klik 'Bagikan' → 4. Copy link dan
                                        paste di sini<br>
                                        <strong>Mendukung:</strong> Link pendek (maps.app.goo.gl) dan link panjang Google
                                        Maps
                                    </small>
                                    <div id="previewContainer" class="mt-3" style="display:none;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0">Preview Google Maps:</label>
                                            <small class="text-muted">Klik peta untuk membuka di Google Maps</small>
                                        </div>
                                        <div class="ratio ratio-16x9 position-relative"
                                            style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                                            <iframe id="previewIframe" src=""
                                                style="border:0; width:100%; height:100%;" loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                            <div id="mapClickOverlay" class="position-absolute top-0 start-0 w-100 h-100"
                                                style="background: transparent; cursor: pointer; z-index: 10;"
                                                onclick="openOriginalMap()" title="Klik untuk membuka di Google Maps"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon"
                                        value="{{ old('nomor_telepon') }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="nib" class="form-label">NIB (Nomor Induk Berusaha) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nib" name="nib"
                                        value="{{ old('nib') }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="alamat" class="form-label">Alamat Lengkap <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required
                                        placeholder="Masukkan alamat lengkap usaha Anda (contoh: Jl. Sudirman No. 123, Kelurahan ABC, Kecamatan XYZ, Kota Jakarta)">{{ old('alamat') }}</textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Usaha <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                                    <small class="text-muted">Ceritakan tentang usaha Anda, produk/jasa yang ditawarkan,
                                        dll.</small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="foto" class="form-label">Foto Usaha</label>
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        accept="image/*" onchange="previewImages()">
                                    <small class="text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.</small>

                                    <div id="image-preview" class="mt-3 row"></div>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('umkm.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Daftarkan UMKM
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/umkm/create.css') }}">
    <script src="{{ asset('js/umkm/create.js') }}"></script>
@endsection
