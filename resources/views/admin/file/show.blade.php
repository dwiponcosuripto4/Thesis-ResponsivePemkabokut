@extends('admin.layouts.navigation')

@section('content')
    <div class="card bg-white p-4 shadow rounded-4 border-0">
        <h4 class="mb-4">Preview File: {{ $file->title }}</h4>
        <div class="mb-3">
            <strong>Nama File:</strong>
            @php
                $displayPath = $file->file_path;
                if (is_string($displayPath)) {
                    $displayPath = trim($displayPath, '"');
                    $displayPath = str_replace('\/', '/', $displayPath);
                } elseif (is_array($displayPath)) {
                    $displayPath = $displayPath[0] ?? 'Unknown';
                    $displayPath = str_replace('\/', '/', $displayPath);
                }
            @endphp
            {{ basename($displayPath) }}<br>
            <strong>Tanggal:</strong> {{ $file->file_date }}<br>
            <strong>Dokumen:</strong> {{ $file->document->title ?? '-' }}
        </div>

        @php
            $filePath = $file->file_path;

            if (is_string($filePath)) {
                // Remove extra quotes and handle JSON string
                $filePath = trim($filePath, '"');
                $filePath = str_replace('\/', '/', $filePath);
            }

            // If it's array, get first element
if (is_array($filePath)) {
    $filePath = $filePath[0] ?? null;
    if ($filePath) {
        $filePath = str_replace('\/', '/', $filePath);
    }
}

// Determine if it's a URL or local file
            $isUrl =
                is_string($filePath) &&
                (str_starts_with($filePath, 'http://') || str_starts_with($filePath, 'https://'));

            if ($isUrl) {
                $url = $filePath;
                $ext = strtolower(pathinfo(parse_url($filePath, PHP_URL_PATH), PATHINFO_EXTENSION));
            } else {
                $url = route('file.serve', $file->id);
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            }
        @endphp

        @if ($ext === 'pdf')
            <div class="mb-2">
                <span class="badge bg-danger"><i class="fas fa-file-pdf"></i> PDF</span>
            </div>
            <iframe src="{{ $url }}" width="100%" height="600px"
                style="border:1px solid #ccc; border-radius: 5px;"></iframe>
        @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            <div class="mb-2">
                <span class="badge bg-success"><i class="fas fa-image"></i> {{ strtoupper($ext) }}</span>
            </div>
            <div class="text-center">
                <img src="{{ $url }}" class="img-fluid rounded shadow" style="max-height: 600px; max-width: 100%;"
                    alt="{{ $file->title }}">
            </div>
        @elseif(in_array($ext, ['xls', 'xlsx']))
            <div class="mb-2">
                <span class="badge bg-success"><i class="fas fa-file-excel"></i> {{ strtoupper($ext) }}</span>
            </div>
            <div class="mb-3">
                @if ($isUrl)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Preview Excel dengan Google Docs Viewer:
                    </div>
                    <iframe src="https://docs.google.com/viewer?url={{ urlencode($url) }}&embedded=true" width="100%"
                        height="600px" style="border:1px solid #ccc; border-radius: 5px;">
                    </iframe>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-download"></i> File Excel tidak dapat di-preview langsung dari server lokal.
                        Silakan download untuk melihat isi file.
                    </div>
                @endif

                <div class="mt-3 text-center">
                    <a href="{{ route('file.download', $file->id) }}" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download File Excel
                    </a>
                </div>
            </div>
        @else
            <div class="mb-2">
                <span class="badge bg-secondary"><i class="fas fa-file"></i> {{ strtoupper($ext ?: 'Unknown') }}</span>
            </div>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Preview untuk file ini tidak tersedia.
                <br><small>Ekstensi file: {{ $ext ?: 'tidak dikenal' }}</small>
            </div>
            <div class="text-center">
                <a href="{{ route('file.download', $file->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download File
                </a>
            </div>
        @endif
    </div>
@endsection
