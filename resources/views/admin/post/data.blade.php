@extends('admin.layouts.navigation')

@section('title', 'Data Posts')

@section('content')

    <!-- Blue Background Section -->
    <div
        style="background: linear-gradient(rgba(7, 63, 151, 0.8), rgba(7, 63, 151, 0.8)), url('{{ asset('images/Perjaya.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; margin: -21px -23px 0 -23px; padding: 20px 20px 120px 20px;">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px;">
                        <div>
                            <h1 class="h3 mb-1 text-white">Post Management</h1>
                            <p class="text-white-50 mb-0">Kelola semua artikel dan berita yang dipublikasikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4" style="margin-top: -100px; position: relative; z-index: 10;">


        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded me-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Posts</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Published Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-success text-white rounded me-3">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Published</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->where('draft', 0)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Draft Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-warning text-white rounded me-3">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Draft</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->where('draft', 1)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- With Thumbnail Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-info text-white rounded me-3">
                            <i class="fas fa-images"></i>
                        </div>
                        <div>
                            <div class="text-muted small">With Thumbnail</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->whereNotNull('image')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- With Category Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-secondary text-white rounded me-3">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div>
                            <div class="text-muted small">With Category</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->whereNotNull('category_id')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- With Headline Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-danger text-white rounded me-3">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <div class="text-muted small">With Headline</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $posts->whereNotNull('headline_id')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Active Filters Info -->
        @if (($category_filter && $category_filter !== 'all') || ($headline_filter && $headline_filter !== 'all'))
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-filter me-2"></i>
                        <div>
                            <strong>Active Filters:</strong>
                            @if ($category_filter && $category_filter !== 'all')
                                <span class="badge bg-primary ms-2">
                                    Category:
                                    @if ($category_filter === 'no_category')
                                        No Category
                                    @else
                                        {{ $categories->where('id', $category_filter)->first()->title ?? 'Unknown' }}
                                    @endif
                                </span>
                            @endif
                            @if ($headline_filter && $headline_filter !== 'all')
                                <span class="badge bg-success ms-2">
                                    Headline:
                                    @if ($headline_filter === 'no_headline')
                                        No Headline
                                    @else
                                        {{ $headlines->where('id', $headline_filter)->first()->title ?? 'Unknown' }}
                                    @endif
                                </span>
                            @endif
                            <a href="{{ url('/admin/post/data?sort_order=' . $sort_order) }}"
                                class="btn btn-sm btn-outline-secondary ms-3">
                                <i class="fas fa-times me-1"></i>Clear All Filters
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Posts Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="m-0 font-weight-bold text-primary mb-3 mb-md-0">Posts Data</h6>
                    <div class="d-none d-md-flex gap-2 align-items-center">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control form-control-sm" placeholder="Search posts..."
                                id="searchPost">
                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <form method="GET" action="{{ url('/admin/post/data') }}" class="d-flex gap-2 align-items-center"
                            id="filterForm">
                            <input type="hidden" name="sort_order" value="{{ $sort_order }}">

                            <select name="category_filter" class="form-select form-select-sm" style="width: 150px;"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="all" {{ ($category_filter ?? 'all') === 'all' ? 'selected' : '' }}>All
                                    Categories</option>
                                <option value="no_category"
                                    {{ ($category_filter ?? '') === 'no_category' ? 'selected' : '' }}>
                                    No Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ ($category_filter ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="headline_filter" class="form-select form-select-sm" style="width: 150px;"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="all" {{ ($headline_filter ?? 'all') === 'all' ? 'selected' : '' }}>All
                                    Headlines</option>
                                <option value="no_headline"
                                    {{ ($headline_filter ?? '') === 'no_headline' ? 'selected' : '' }}>
                                    No Headline</option>
                                @foreach ($headlines as $headline)
                                    <option value="{{ $headline->id }}"
                                        {{ ($headline_filter ?? '') == $headline->id ? 'selected' : '' }}>
                                        {{ $headline->title }}
                                    </option>
                                @endforeach
                            </select>

                            @if (($category_filter && $category_filter !== 'all') || ($headline_filter && $headline_filter !== 'all'))
                                <a href="{{ url('/admin/post/data?sort_order=' . $sort_order) }}"
                                    class="btn btn-outline-warning btn-sm" title="Clear Filters">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </form>

                        <a href="{{ url(
                            '/admin/post/data?sort_order=' .
                                ($sort_order == 'asc' ? 'desc' : 'asc') .
                                ($category_filter ? '&category_filter=' . $category_filter : '') .
                                ($headline_filter ? '&headline_filter=' . $headline_filter : ''),
                        ) }}"
                            class="btn btn-outline-secondary btn-sm" title="Sort Posts">
                            <i class="fas fa-sort"></i>
                        </a>

                        <a href="/admin/post/create" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Add Post
                        </a>

                        <button class="btn btn-danger btn-sm" onclick="downloadPostReport()"
                            title="Download Laporan PDF">
                            <i class="fas fa-file-pdf me-1"></i>Laporan
                        </button>
                    </div>

                    <div class="d-flex d-md-none gap-2 align-items-center flex-wrap w-100">
                        <div class="input-group mb-2" style="width: 100%;">
                            <input type="text" class="form-control form-control-sm" placeholder="Search posts..."
                                id="searchPostMobile">
                            <button class="btn btn-outline-secondary btn-sm" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <form method="GET" action="{{ url('/admin/post/data') }}"
                            class="d-flex gap-2 align-items-center flex-wrap w-100" id="filterFormMobile">
                            <input type="hidden" name="sort_order" value="{{ $sort_order }}">

                            <select name="category_filter" class="form-select form-select-sm mb-2" style="width: 100%;"
                                onchange="document.getElementById('filterFormMobile').submit();">
                                <option value="all" {{ ($category_filter ?? 'all') === 'all' ? 'selected' : '' }}>All
                                    Categories</option>
                                <option value="no_category"
                                    {{ ($category_filter ?? '') === 'no_category' ? 'selected' : '' }}>
                                    No Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ ($category_filter ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="headline_filter" class="form-select form-select-sm mb-2" style="width: 100%;"
                                onchange="document.getElementById('filterFormMobile').submit();">
                                <option value="all" {{ ($headline_filter ?? 'all') === 'all' ? 'selected' : '' }}>All
                                    Headlines</option>
                                <option value="no_headline"
                                    {{ ($headline_filter ?? '') === 'no_headline' ? 'selected' : '' }}>
                                    No Headline</option>
                                @foreach ($headlines as $headline)
                                    <option value="{{ $headline->id }}"
                                        {{ ($headline_filter ?? '') == $headline->id ? 'selected' : '' }}>
                                        {{ $headline->title }}
                                    </option>
                                @endforeach
                            </select>

                            @if (($category_filter && $category_filter !== 'all') || ($headline_filter && $headline_filter !== 'all'))
                                <a href="{{ url('/admin/post/data?sort_order=' . $sort_order) }}"
                                    class="btn btn-outline-warning btn-sm mb-2" style="width: 100%;"
                                    title="Clear Filters">
                                    <i class="fas fa-times me-1"></i>Clear Filters
                                </a>
                            @endif
                        </form>

                        <a href="{{ url(
                            '/admin/post/data?sort_order=' .
                                ($sort_order == 'asc' ? 'desc' : 'asc') .
                                ($category_filter ? '&category_filter=' . $category_filter : '') .
                                ($headline_filter ? '&headline_filter=' . $headline_filter : ''),
                        ) }}"
                            class="btn btn-outline-secondary btn-sm mb-2" style="width: 100%;" title="Sort Posts">
                            <i class="fas fa-sort me-1"></i>Sort
                        </a>

                        <a href="/admin/post/create" class="btn btn-primary btn-sm mb-2" style="width: 100%;">
                            <i class="fas fa-plus me-2"></i>Add Post
                        </a>

                        <button class="btn btn-danger btn-sm mb-2" style="width: 100%;" onclick="downloadPostReport()"
                            title="Download Laporan PDF">
                            <i class="fas fa-file-pdf me-1"></i>Laporan
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Success Messages --}}
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="postsTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="3%">No</th>
                                <th width="15%">Image</th>
                                <th width="23%">Title</th>
                                <th width="10%">Author</th>
                                <th width="8%">Category</th>
                                <th width="10%">Headline</th>
                                <th width="5%">ID</th>
                                <th width="8%">Published</th>
                                <th width="10%">Updated At</th>
                                <th width="8%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $index => $post)
                                <tr>
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        @php
                                            // Handle different image storage formats
                                            $imageUrl = null;
                                            $debugInfo = '';

                                            if ($post->image) {
                                                $debugInfo = 'Raw: ' . substr($post->image, 0, 50) . '...';

                                                // If image is stored as JSON array
                                                if (
                                                    is_string($post->image) &&
                                                    (str_starts_with($post->image, '[') ||
                                                        str_starts_with($post->image, '{"'))
                                                ) {
                                                    $images = json_decode($post->image, true);
                                                    if (is_array($images) && count($images) > 0) {
                                                        $imageUrl = is_array($images[0])
                                                            ? $images[0]['path'] ?? ($images[0]['url'] ?? $images[0])
                                                            : $images[0];
                                                    }
                                                    $debugInfo = 'JSON decoded, first: ' . ($imageUrl ?? 'null');
                                                } else {
                                                    // If image is stored as single string
                                                    $imageUrl = $post->image;
                                                    $debugInfo = 'String: ' . $imageUrl;
                                                }
                                            }
                                        @endphp

                                        @if ($imageUrl)
                                            <div class="image-container">
                                                @php
                                                    // Clean the image URL
                                                    $imageUrl = trim($imageUrl, '"\'');

                                                    // Try different possible paths where images might be stored
                                                    $possiblePaths = [
                                                        'storage/uploads/' . $imageUrl,
                                                        'storage/' . $imageUrl,
                                                        'upload/' . $imageUrl,
                                                        'uploads/' . $imageUrl,
                                                        'public/upload/' . $imageUrl,
                                                        'img/' . $imageUrl,
                                                        'images/' . $imageUrl,
                                                        $imageUrl,
                                                    ];

                                                    $imageSrc = null;

                                                    if (str_starts_with($imageUrl, 'http')) {
                                                        $imageSrc = $imageUrl;
                                                    } else {
                                                        // Try each possible path
                                                        foreach ($possiblePaths as $path) {
                                                            if (file_exists(public_path($path))) {
                                                                $imageSrc = asset($path);
                                                                break;
                                                            }
                                                        }

                                                        // If no file found, default to storage/uploads path
                                                        if (!$imageSrc) {
                                                            $imageSrc = asset('storage/uploads/' . $imageUrl);
                                                        }
                                                    }
                                                @endphp

                                                <img src="{{ $imageSrc }}" alt="{{ $post->title }}"
                                                    class="post-thumbnail rounded" style="cursor: pointer;"
                                                    onclick="openLightbox('{{ $imageSrc }}')"
                                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMkg0MFYzOEgyMFYyMloiIGZpbGw9IiM5Q0EzQUYiLz4KPHBhdGggZD0iTTI1IDI3QzI2LjEwNDYgMjcgMjcgMjYuMTA0NiAyNyAyNUMyNyAyMy44OTU0IDI2LjEwNDYgMjMgMjUgMjNDMjMuODk1NCAyMyAyMyAyMy44OTU0IDIzIDI1QzIzIDI2LjEwNDYgMjMuODk1NCAyNyAyNSAyN1oiIGZpbGw9IiM2Qjc3ODUiLz4KPHBhdGggZD0iTTM3IDM1TDMzIDMxTDI5IDM1SDM3WiIgZmlsbD0iIzZCNzc4NSIvPgo8L3N2Zz4K'; this.onerror=null;">
                                            </div>
                                        @else
                                            <div class="no-image-placeholder">
                                                <i class="fas fa-image text-muted"></i>
                                                <small class="text-muted d-block">No Image</small>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="post-title-container">
                                            <span class="post-title">{{ $post->title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name ?? 'Unknown') }}&color=7F9CF5&background=EBF4FF&size=32"
                                                    alt="User" class="rounded-circle" width="32" height="32">
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $post->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">ID: {{ $post->user_id ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($post->category)
                                            <span class="badge bg-info rounded-pill px-3 py-1">
                                                {{ $post->category->title }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-1">No Category</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($post->headline)
                                            <span class="badge bg-success rounded-pill px-3 py-1">
                                                {{ Str::limit($post->headline->title, 20) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-1">No Headline</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $post->id }}</td>
                                    <td class="text-center">
                                        @if ($post->published_at)
                                            <span class="text-sm">
                                                {{ $post->published_at->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($post->updated_at)
                                            <span class="text-sm">{{ $post->updated_at->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            <div class="d-flex justify-content-center gap-1 mb-1">
                                                <a href="/post/show/{{ $post->id }}" class="btn btn-success btn-sm"
                                                    title="View Post" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="/admin/post/edit/{{ $post->id }}"
                                                    class="btn btn-primary btn-sm" title="Edit Post">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Delete Post"
                                                    onclick="deletePost({{ $post->id }}, '{{ addslashes($post->title) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.post.toggleDraft', $post->id) }}"
                                                method="POST" class="w-100 text-center">
                                                @csrf
                                                @method('PATCH')
                                                @if ($post->draft)
                                                    <button type="submit" class="btn btn-warning btn-sm w-100 mt-1"
                                                        title="Publish Post">
                                                        <i class="fas fa-upload"></i> Publish
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-secondary btn-sm w-100 mt-1"
                                                        title="Set as Draft">
                                                        <i class="fas fa-file-alt"></i> Draft
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-newspaper fa-3x mb-3 text-gray-300"></i>
                                            <h5>No posts available</h5>
                                            <p>Create your first post to get started</p>
                                            <a href="/admin/post/create" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Create Post
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $posts->count() }} posts
                    </div>
                    @if ($posts->count() > 10)
                        <nav aria-label="Posts pagination">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Image Lightbox Modal -->
    <div class="image-lightbox" id="imageLightbox">
        <button class="image-lightbox-close" onclick="closeLightbox()">&times;</button>
        <img src="" alt="Lightbox Image" id="lightboxImage">
    </div>

    <link rel="stylesheet" href="{{ asset('css/admin/post/data.css') }}">

    <script src="{{ asset('js/admin/post/data.js') }}"></script>
@endsection
