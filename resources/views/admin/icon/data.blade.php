@extends('admin.layouts.navigation')

@section('title', 'Data Icons')

@section('content')
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 120px 20px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                        <div>
                            <h1 class="h3 mb-1 text-white">Portal Management</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4" style="margin-top: -120px; position: relative; z-index: 10;">
        <div class="card bg-white p-4 shadow rounded-4 border-0">
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h4>Data Portal</h4>
                </div>
                <div>
                    <a href="{{ route('icon.create') }}" class="btn btn-primary">Add new Portal</a>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Informasi:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Dropdowns</th>
                            <th>User ID</th>
                            <th>Created At</th>
                            <th>Updated At</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($icons as $icon)
                            <tr>
                                <td>{{ $icon->id }}</td>
                                <td>{{ $icon->title }}</td>
                                <td>
                                    <div
                                        class="table-icon-section d-flex flex-column gap-2 justify-content-center align-items-center">
                                        <div class="card bg-opacity-60 text-center">
                                            <div class="card-body">
                                                @php
                                                    // Cek apakah gambar merupakan URL eksternal
                                                    $isExternalImage = Str::startsWith($icon->image, [
                                                        'http://',
                                                        'https://',
                                                    ]);
                                                @endphp

                                                <!-- Jika gambar merupakan URL eksternal -->
                                                @if ($isExternalImage)
                                                    <img src="{{ $icon->image }}" alt="{{ $icon->title }}"
                                                        class="img-fluid"
                                                        style="width: 50px; height: 50px; object-fit: contain;">
                                                @else
                                                    <img src="{{ asset('storage/' . $icon->image) }}"
                                                        alt="{{ $icon->title }}" class="img-fluid"
                                                        style="width: 50px; height: 50px; object-fit: contain;">
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $icon->dropdowns->count() }}</td>
                                <td>
                                    @if ($icon->user)
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($icon->user->name ?? 'Unknown') }}&color=7F9CF5&background=EBF4FF&size=32"
                                                alt="User" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <div class="fw-medium">{{ $icon->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">ID: {{ $icon->user_id ?? '-' }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $icon->created_at->format('d M Y, H:i') }}</td>
                                <td>{{ $icon->updated_at->format('d M Y, H:i') }}</td>

                                <td>
                                    <a href="{{ route('icon.edit', $icon->id) }}" class="btn btn-info">Edit</a>
                                    <form action="{{ route('icon.destroy', $icon->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this icon?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <link rel="stylesheet" href="{{ asset('css/admin/portal.css') }}">
    @endsection
