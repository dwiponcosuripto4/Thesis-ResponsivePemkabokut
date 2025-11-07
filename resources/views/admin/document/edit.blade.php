@extends('admin.layouts.navigation')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="text-center mb-4">
                    <h1 class="h3 h1-md">Edit Document and Files</h1>
                </div>

                <form action="{{ route('document.update', $document->id) }}" method="post" enctype="multipart/form-data"
                    id="file-form">
                    @csrf
                    @method('PATCH')

                    <div class="form-group mb-3">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title', $document->title) }}">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="data_id">Data:</label>
                        <select name="data_id" class="form-control" id="data-select">
                            <option value="">-- Select Data --</option>
                            @foreach ($data as $dataItem)
                                <option value="{{ $dataItem->id }}"
                                    {{ $dataItem->id == $document->data_id ? 'selected' : '' }}>
                                    {{ $dataItem->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="current_files" class="form-label">Current Files:</label>
                        @if ($document->file->isNotEmpty())
                            @foreach ($document->file as $index => $file)
                                <div class="file-item-wrapper mb-3 p-3 border rounded">
                                    <div class="file-item-content">
                                        <div class="file-item-left">
                                            <img src="{{ asset('icons/' . strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)) . '-icon.png') }}"
                                                alt="File Icon" class="file-icon">
                                            <div class="file-info">
                                                <label class="form-label mb-1">File Title</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="existing_files[{{ $file->id }}][title]"
                                                    value="{{ old('existing_files.' . $file->id . '.title', $file->title ?? basename($file->file_path)) }}"
                                                    placeholder="Enter file title">
                                                <small class="text-muted d-block mt-1 file-name">File:
                                                    {{ str_replace('files/', '', $file->file_path) }}</small>
                                            </div>
                                        </div>
                                        <div class="file-item-actions">
                                            <a href="{{ route('file.download', $file->id) }}"
                                                class="btn btn-sm btn-outline-primary btn-download" target="_blank">
                                                <i class="fas fa-download"></i>
                                                <span class="btn-text">Download</span>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete-existing-file btn-delete-circle"
                                                data-file-id="{{ $file->id }}">×</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No files uploaded yet.</p>
                        @endif
                    </div>

                    <div id="file-sections">
                        <div class="file-section mb-3 p-3 border rounded">
                            <div class="row g-2">
                                <div class="col-12 col-md-5">
                                    <label class="form-label">File Title</label>
                                    <input type="text" class="form-control form-control-sm" name="files[0][title]"
                                        placeholder="Enter file title">
                                </div>
                                <div class="col-12 col-md-5">
                                    <label class="form-label">Upload File</label>
                                    <input type="file" class="form-control form-control-sm" name="files[0][file]">
                                </div>
                                <div class="col-12 col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-file-section w-100"
                                        style="min-height: 38px;">
                                        <i class="fas fa-trash me-1"></i>
                                        <span class="d-inline">Remove</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-file-btn" class="btn btn-secondary btn-sm mb-3 w-100 w-md-auto">
                        <i class="fas fa-plus me-1"></i>Add Another File
                    </button>

                    <div class="mb-3">
                        <label for="file_date" class="form-label">File Date</label>
                        <input type="date" class="form-control" id="file_date" name="file_date"
                            value="{{ old('file_date', $document->file->first()->file_date ?? '') }}" required>
                    </div>

                    <div class="d-grid d-md-flex justify-content-md-end gap-2">
                        <a href="{{ route('document.data') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/admin/document/edit.css') }}">

    <script src="{{ asset('js/admin/document/edit.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
