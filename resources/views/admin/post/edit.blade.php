<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Post - Sistem Admin Portal Informasi OKU Timur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/post/edit.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <div class="form-progress">
        <div class="form-progress-bar" id="formProgress"></div>
    </div>

    <button class="sidebar-toggle-btn" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <button class="mobile-hamburger-btn" id="mobileHamburger">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <img src="{{ asset('icons/logo_okutimur.png') }}" alt="Logo OKU Timur" class="brand-logo">
                <div class="brand-text">
                    <div class="brand-text-top">Sistem Admin</div>
                    <div class="brand-text-bottom">Portal Informasi OKU Timur</div>
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <ul class="sidebar-nav first-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            <div class="nav-section">
                <div class="nav-section-title">INFORMASI PUBLIK</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('category.data') }}" class="nav-link">
                            <i class="fas fa-tags"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('post.data') }}" class="nav-link active">
                            <i class="fas fa-newspaper"></i>
                            <span>Posts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('headline.data') }}" class="nav-link">
                            <i class="fas fa-bullhorn"></i>
                            <span>Headlines</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">DOKUMEN PUBLIK</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('data.index') }}" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Data</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('document.data') }}" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('file.data') }}" class="nav-link">
                            <i class="fas fa-folder"></i>
                            <span>Files</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">LAYANAN MASYARAKAT</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('icon.data') }}" class="nav-link">
                            <i class="fas fa-globe"></i>
                            <span>Portal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.businesses.index') }}" class="nav-link">
                            <i class="fas fa-store"></i>
                            <span>UMKM</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="page-content form-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-11 col-md-offset-0" style="margin-left: auto; margin-right: auto; float: none;">
                        <div class="modern-header">
                            <div class="header-content">
                                <div class="header-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="header-text">
                                    <h1 class="header-title">Edit Post</h1>
                                    <p class="header-subtitle">Mengubah postingan berita untuk masyarakat</p>
                                </div>
                            </div>
                            <div class="header-decoration"></div>
                        </div>

                        <div class="modern-form-card">
                            <form id="create-post-form" action="{{ route('post.update', $post->id) }}"
                                method="post" enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-heading section-icon"></i>
                                        <h3 class="section-title">Post Information</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group-modern full-width">
                                            <div class="input-wrapper">
                                                <label for="title" class="modern-label">
                                                    <i class="fas fa-pen"></i>
                                                    Title
                                                </label>
                                                <input type="text" class="modern-input" name="title"
                                                    id="title" placeholder="Enter an engaging title for your post"
                                                    value="{{ $post->title }}">
                                                <div class="input-border"></div>
                                            </div>
                                            <div id="title-error" class="error-message"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-tags section-icon"></i>
                                        <h3 class="section-title">Classification</h3>
                                    </div>
                                    <div class="form-grid two-columns">
                                        <div class="form-group-modern">
                                            <div class="select-wrapper">
                                                <label for="category_id" class="modern-label">
                                                    <i class="fas fa-folder"></i>
                                                    Category
                                                </label>
                                                <select name="category_id" class="modern-select"
                                                    id="category-select">
                                                    <option value="">Choose a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="category-error" class="error-message"></div>
                                        </div>

                                        <div class="form-group-modern">
                                            <div class="select-wrapper">
                                                <label for="headline_id" class="modern-label">
                                                    <i class="fas fa-star"></i>
                                                    Headline
                                                </label>
                                                <select name="headline_id" class="modern-select"
                                                    id="headline-select">
                                                    <option value="">Choose a headline</option>
                                                    @foreach ($headlines as $headline)
                                                        <option value="{{ $headline->id }}"
                                                            {{ $post->headline_id == $headline->id ? 'selected' : '' }}>
                                                            {{ $headline->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="headline-error" class="error-message"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-images section-icon"></i>
                                        <h3 class="section-title">Media Gallery</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="image-upload-area">
                                            <div class="upload-zone"
                                                onclick="document.getElementById('image-upload').click()">
                                                <div class="upload-icon">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <div class="upload-text">
                                                    <h4>Click to upload images</h4>
                                                    <p>or drag and drop your files here</p>
                                                    <small>Supports: JPG, PNG, GIF (Max: 5MB each)</small>
                                                </div>
                                                <input type="file" class="hidden-input" name="images[]"
                                                    id="image-upload" multiple>
                                            </div>
                                            <button type="button" id="add-image-btn" class="btn-add-image">
                                                <i class="fas fa-plus"></i>
                                                Add More Images
                                            </button>
                                        </div>
                                        <div id="image-preview" class="image-preview-grid">
                                            @if ($post->image)
                                                @php
                                                    $images = json_decode($post->image);
                                                @endphp
                                                @foreach ($images as $image)
                                                    <div class="file-item">
                                                        @php
                                                            $isExternalImage = Str::startsWith($image, [
                                                                'http://',
                                                                'https://',
                                                            ]);
                                                        @endphp
                                                        <img src="{{ $isExternalImage ? $image : asset('storage/' . $image) }}"
                                                            style="max-width: 300px; height: auto; display: block; border-radius: 12px;"
                                                            alt="Uploaded Image">
                                                        <button class="remove-file-btn"
                                                            data-image="{{ $image }}"
                                                            type="button">&times;</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-edit section-icon"></i>
                                        <h3 class="section-title">Content</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group-modern full-width">
                                            <label for="description" class="modern-label">
                                                <i class="fas fa-align-left"></i>
                                                Description
                                            </label>
                                            <div class="editor-wrapper">
                                                <textarea name="description" id="description" cols="30" rows="10">{{ $post->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-header">
                                        <i class="fas fa-calendar-alt section-icon"></i>
                                        <h3 class="section-title">Publish Settings</h3>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group-modern">
                                            <div class="input-wrapper">
                                                <label for="published_at" class="modern-label">
                                                    <i class="fas fa-clock"></i>
                                                    Publish Date & Time
                                                </label>
                                                <input type="datetime-local" class="modern-input" name="published_at"
                                                    id="published_at"
                                                    value="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : date('Y-m-d\TH:i') }}">
                                                <div class="input-border"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit-section">
                                    <div class="submit-buttons">
                                        <button type="button" class="btn-draft">
                                            <i class="fas fa-save"></i>
                                            Save as Draft
                                        </button>
                                        <button type="submit" class="btn-publish">
                                            <i class="fas fa-save"></i>
                                            Update Post
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/post/edit.js') }}"></script>
</body>

</html>
