@extends('admin.layouts.navigation')

@section('title', 'Data Documents')

@section('content')
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 120px 20px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                        <div>
                            <h1 class="h3 mb-1 text-white">Documents Management</h1>
                            <p class="text-white-50 mb-0">Kelola semua dokumen yang ada di sistem</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4" style="margin-top: -100px; position: relative; z-index: 10;">


        <!-- Documents Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div
                    class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                    <h6 class="m-0 font-weight-bold text-primary">Documents Data</h6>

                    <!-- Mobile & Desktop Controls -->
                    <div class="d-flex flex-column flex-md-row gap-2 w-100 w-lg-auto">
                        <!-- Search Box -->
                        <div class="input-group input-group-sm" style="min-width: 200px;">
                            <input type="text" class="form-control form-control-sm" placeholder="Cari dokumen..."
                                id="searchDocument">
                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ url('/admin/document/data') }}"
                            class="d-flex gap-2 align-items-center" id="filterForm">
                            <select name="data_filter" class="form-select form-select-sm" style="min-width: 150px;"
                                onchange="this.form.submit()">
                                <option value="all" {{ ($data_filter ?? 'all') === 'all' ? 'selected' : '' }}>Semua Data
                                </option>
                                <option value="no_data" {{ ($data_filter ?? '') === 'no_data' ? 'selected' : '' }}>Tanpa
                                    Data
                                </option>
                                @foreach ($datas as $data)
                                    <option value="{{ $data->id }}"
                                        {{ ($data_filter ?? '') == $data->id ? 'selected' : '' }}>
                                        {{ $data->title }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="sort" value="{{ request('sort', 'desc') }}">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>

                        <!-- Sort Button -->
                        <form method="GET" action="{{ url('/admin/document/data') }}" class="d-flex" id="sortForm">
                            <input type="hidden" name="data_filter" value="{{ $data_filter ?? 'all' }}">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <button type="submit" name="sort" value="{{ request('sort') === 'asc' ? 'desc' : 'asc' }}"
                                class="btn btn-outline-secondary btn-sm text-nowrap"
                                title="Urutkan berdasarkan tanggal {{ request('sort') === 'asc' ? 'terbaru' : 'terlama' }}">
                                <i class="fas fa-sort-amount-{{ request('sort', 'desc') === 'desc' ? 'down' : 'up' }}"></i>
                                <span
                                    class="d-none d-md-inline ms-1">{{ request('sort', 'desc') === 'desc' ? 'Terbaru' : 'Terlama' }}</span>
                            </button>
                        </form>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('document.create') }}" class="btn btn-primary btn-sm text-nowrap">
                                <i class="fas fa-plus me-1 d-none d-sm-inline"></i><span class="d-none d-sm-inline">Add
                                </span>Document
                            </a>
                            <button class="btn btn-danger btn-sm text-nowrap" onclick="downloadDocumentReport()"
                                title="Download Laporan PDF">
                                <i class="fas fa-file-pdf me-1"></i><span class="d-none d-sm-inline">Laporan</span><span
                                    class="d-inline d-sm-none">PDF</span>
                            </button>
                        </div>
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
                    <table class="table table-bordered table-hover" id="documentsTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="3%">No</th>
                                <th width="25%">Title</th>
                                <th width="7%">Jumlah File</th>
                                <th width="5%">Data</th>
                                <th width="1%">ID</th>
                                <th width="6%">Date</th>
                                <th width="15%">User ID</th>
                                <th width="1%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $index => $document)
                                <tr>
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>

                                    <td>{{ $document->title }}</td>
                                    <td class="text-center">{{ $document->file->count() }}</td>
                                    <td data-id="{{ $document->data->id ?? '' }}">
                                        {{ $document->data->title ?? 'No Data' }}</td>
                                    <td class="text-center">{{ $document->id }}</td>
                                    <td>{{ $document->date ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($document->user)
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($document->user->name ?? 'Unknown') }}&color=7F9CF5&background=EBF4FF&size=32"
                                                    alt="User" class="rounded-circle me-2" width="32"
                                                    height="32">
                                                <div>
                                                    <div class="fw-medium">{{ $document->user->name ?? 'Unknown' }}</div>
                                                    <small class="text-muted">ID: {{ $document->user_id ?? '-' }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 8px; align-items: center;">
                                            <a href="{{ route('document.show', $document->id) }}"
                                                class="btn btn-success btn-sm">Show</a>
                                            <a href="{{ route('document.edit', $document->id) }}"
                                                class="btn btn-info btn-sm">Edit</a>
                                            <form action="{{ route('document.destroy', $document->id) }}" method="POST"
                                                style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
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
    </div>

    <script src="{{ asset('js/admin/document/data.js') }}"></script>
@endsection
