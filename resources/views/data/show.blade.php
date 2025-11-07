@extends('layout')

@section('content')
    <div class="container py-4" style="margin-top: 100px; min-height: 100vh;">
        <h2 class="fw-bold mb-4" style="color:#333;">{{ $data->title }}</h2>
        <div class="mb-4">
            <div class="documents-list">
                @forelse($data->documents as $document)
                    <div class="document-item py-3" style="border-bottom: 1px solid #e0e0e0;">
                        <div class="text-muted mb-2" style="font-size:0.9rem;">
                            {{ \Carbon\Carbon::parse($document->created_at)->format('d M Y') }}
                        </div>
                        <a href="{{ route('document.show', $document->id) }}" class="fw-bold d-block"
                            style="font-size:1.1rem; color:#f37021; text-decoration:none; line-height: 1.4;">
                            {{ $document->title }}
                        </a>
                    </div>
                @empty
                    <div class="text-muted py-3">Tidak ada dokumen terkait.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
