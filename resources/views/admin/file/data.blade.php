@extends('admin.layouts.navigation')

@section('title', 'Data Files')

@section('content')
    <link href="{{ asset('admin/css/file/data.css') }}" rel="stylesheet">
    <div class="card bg-white shadow rounded-4 border-0">
        <div class="card-header py-3 bg-white px-3">
            <div
                class="d-flex flex-column flex-lg-row justify-content-start justify-content-lg-between align-items-start align-items-lg-center gap-3">
                <h6 class="m-0 font-weight-bold text-primary">Files Data</h6>

                <!-- Mobile & Desktop Controls -->
                <div class="d-flex flex-column flex-md-row gap-2 w-100 w-lg-auto justify-content-md-end">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('file.data') }}" class="d-flex w-100 w-md-auto" id="searchForm">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" id="searchInput" class="form-control form-control-sm"
                                placeholder="Cari judul file..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary btn-sm" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        @if (request('document_id'))
                            <input type="hidden" name="document_id" value="{{ request('document_id') }}">
                        @endif
                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                    </form>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('file.data') }}"
                        class="d-flex gap-2 align-items-center w-100 w-md-auto" id="filterForm">
                        <select name="document_id" class="form-select form-select-sm flex-grow-1" style="min-width: 150px;"
                            onchange="this.form.submit()">
                            <option value="">Semua Dokumen</option>
                            @foreach ($documents as $document)
                                <option value="{{ $document->id }}"
                                    {{ request('document_id') == $document->id ? 'selected' : '' }}>
                                    {{ $document->title }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="sort" value="{{ request('sort', 'desc') }}">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                    </form>

                    <!-- Sort Button -->
                    <form method="GET" action="{{ route('file.data') }}" class="d-flex" id="sortForm">
                        <input type="hidden" name="document_id" value="{{ request('document_id', '') }}">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <button type="submit" name="sort" value="{{ request('sort') === 'asc' ? 'desc' : 'asc' }}"
                            class="btn btn-outline-secondary btn-sm text-nowrap"
                            title="Urutkan berdasarkan tanggal {{ request('sort') === 'asc' ? 'terbaru' : 'terlama' }}">
                            <i class="fas fa-sort-amount-{{ request('sort', 'desc') === 'desc' ? 'down' : 'up' }}"></i>
                            <span
                                class="sort-text ms-1">{{ request('sort', 'desc') === 'desc' ? 'Terbaru' : 'Terlama' }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="18%">Title</th>
                            <th width="20%">Path</th>
                            <th width="12%">Date</th>
                            <th width="18%">Document</th>
                            <th width="5%">ID</th>
                            <th width="24%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $index => $file)
                            <tr>
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td>{{ $file->title ?? 'No Title' }}</td>
                                <td>{{ $file->file_path }}</td>
                                <td>{{ $file->file_date }}</td>
                                <td>{{ $file->document->title ?? 'No Document' }}</td>
                                <td class="text-center">{{ $file->id }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="/file/show/{{ $file->id }}" class="btn btn-success btn-sm">Show</a>
                                        <a href="{{ route('file.edit', $file->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('file.destroy', $file->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this file?');"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
