<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Sistem Admin Portal Informasi OKU Timur')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/calendar.css') }}" rel="stylesheet">
</head>

<body>
    <button class="sidebar-toggle-btn" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand text-decoration-none">
                <img src="{{ asset('icons/logo_okutimur.png') }}" alt="Logo OKU Timur" class="brand-logo">
                <div class="brand-text">
                    <div class="brand-text-top">Sistem Admin</div>
                    <div class="brand-text-bottom">Portal Informasi OKU Timur</div>
                </div>
            </a>
        </div>

        <div class="sidebar-content">
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            <div class="nav-section">
                <div class="nav-section-title">INFORMASI PUBLIK</div>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="{{ route('category.data') }}"
                            class="nav-link {{ request()->routeIs('category.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('post.data') }}"
                            class="nav-link {{ request()->routeIs('post.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i>
                            <span>Posts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('headline.data') }}"
                            class="nav-link {{ request()->routeIs('headline.*') ? 'active' : '' }}">
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
                        <a href="{{ route('data.index') }}"
                            class="nav-link {{ request()->routeIs('data.*') ? 'active' : '' }}">
                            <i class="fas fa-database"></i>
                            <span>Data</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('document.data') }}"
                            class="nav-link {{ request()->routeIs('document.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('file.data') }}"
                            class="nav-link {{ request()->routeIs('file.*') ? 'active' : '' }}">
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
                        <a href="{{ route('icon.data') }}"
                            class="nav-link {{ request()->routeIs('icon.*') ? 'active' : '' }}">
                            <i class="fas fa-globe"></i>
                            <span>Portal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.businesses.index') }}"
                            class="nav-link {{ request()->routeIs('admin.businesses.*') ? 'active' : '' }}">
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
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <!-- Hamburger Menu Button (Mobile) -->
                    <button class="navbar-toggler d-lg-none" type="button" id="navbarToggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-lg-none mb-0 h5"
                        style="font-size: 1rem; font-weight: 600; text-decoration: none; color: #2c3e50;">Admin
                        Portal</a>
                </div>

                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <div class="nav-item dropdown me-3">
                        <a class="nav-link notification-icon rounded-circle bg-light hover-effect d-flex align-items-center justify-content-center d-none d-lg-flex"
                            href="#" role="button" id="pendingBusinessNotification"
                            style="border: none; text-decoration: none; position: relative;">
                            <i class="fas fa-bell text-secondary"></i>
                            <span class="position-absolute badge rounded-pill bg-danger badge-notification"
                                id="pendingCount"
                                style="top: -2px; right: -10px; font-size: 0.6rem; min-width: 18px; height: 18px; display: none; align-items: center; justify-content: center;">0</span>
                        </a>
                        <!-- Mobile Notification Button -->
                        <a class="nav-link notification-icon rounded-circle bg-light hover-effect d-flex d-lg-none align-items-center justify-content-center"
                            href="#" id="mobileNotificationBtn"
                            style="border: none; text-decoration: none; position: relative;">
                            <i class="fas fa-bell text-secondary"></i>
                            <span class="position-absolute badge rounded-pill bg-danger badge-notification"
                                id="pendingCountMobile"
                                style="top: -2px; right: -10px; font-size: 0.6rem; min-width: 18px; height: 18px; display: none; align-items: center; justify-content: center;">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" id="notificationDropdown"
                            style="min-width: 400px; max-height: 400px; overflow-y: auto; border-radius: 8px; display: none !important; right: -50px;">
                            <li>
                                <h6 class="dropdown-header text-primary fw-bold">
                                    <i class="fas fa-bell me-2"></i>UMKM Menunggu Persetujuan
                                </h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <div id="pendingBusinessList">
                            </div>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-center text-primary fw-medium"
                                    href="{{ route('admin.businesses.index', ['status' => 0]) }}">
                                    <i class="fas fa-external-link-alt me-2"></i>Lihat Semua
                                </a></li>
                        </ul>
                    </div>

                    <!-- User Profile -->
                    <div class="nav-item dropdown">
                        <a class="nav-link user-profile-link d-none d-lg-flex align-items-center rounded-pill bg-light hover-effect"
                            href="#" role="button" id="userProfileDropdown"
                            style="border: none; text-decoration: none;">
                            @if (Auth::user()->foto && file_exists(storage_path('app/public/users/' . Auth::user()->foto)))
                                <img src="{{ asset('storage/users/' . Auth::user()->foto) }}"
                                    alt="Foto {{ Auth::user()->name }}" class="rounded-circle me-2" width="40"
                                    height="40"
                                    style="object-fit: cover; border: 2px solid #e9ecef; object-position: top;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px; font-size: 14px; font-weight: bold; border: 2px solid #e9ecef;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="fw-medium text-dark d-none d-md-inline">Hi, {{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down ms-2 text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <!-- Mobile Profile Button -->
                        <a class="nav-link user-profile-link d-flex d-lg-none align-items-center rounded-pill bg-light hover-effect"
                            href="#" id="mobileProfileBtn" style="border: none; text-decoration: none;">
                            @if (Auth::user()->foto && file_exists(storage_path('app/public/users/' . Auth::user()->foto)))
                                <img src="{{ asset('storage/users/' . Auth::user()->foto) }}"
                                    alt="Foto {{ Auth::user()->name }}" class="rounded-circle me-2" width="36"
                                    height="36" style="object-fit: cover; object-position: top;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px; font-size: 14px; font-weight: bold; border: 2px solid #e9ecef;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="fw-medium text-dark d-none d-md-inline">Hi, {{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down ms-2 text-muted" style="font-size: 0.8rem;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" id="userProfileMenu"
                            style="border-radius: 8px; display: none;">
                            <li><a class="dropdown-item" href="{{ route('admin.profile.show') }}"><i
                                        class="fas fa-user me-2 text-primary"></i>Profile</a>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#"><i
                                        class="fas fa-cog me-2 text-secondary"></i>Settings</a>
                                <ul class="dropdown-menu">
                                    <li class="settings-item">
                                        <div class="item-info">
                                            <div class="item-title">Hide UMKM Registration</div>
                                            <div class="item-description">Hide UMKM registration button from homepage
                                            </div>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="hideUmkmRegistration"
                                                onchange="toggleUmkmRegistration(this)">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </li>
                                    <li class="settings-item">
                                        <div class="item-info">
                                            <div class="item-title">Hide UMKM Menu</div>
                                            <div class="item-description">Hide UMKM icon menu from homepage</div>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="hideUmkmMenu" onchange="toggleUmkmMenu(this)">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <!-- Mobile Notification Modal -->
    <div class="mobile-modal" id="mobileNotificationModal">
        <div class="mobile-modal-overlay"></div>
        <div class="mobile-modal-content">
            <div class="mobile-modal-header">
                <h5 class="mobile-modal-title">
                    <i class="fas fa-bell me-2"></i>Notifikasi UMKM
                </h5>
                <button class="mobile-modal-close" id="closeNotificationModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mobile-modal-body" id="mobileNotificationBody">
            </div>
            <div class="mobile-modal-footer">
                <a href="{{ route('admin.businesses.index', ['status' => 0]) }}" class="btn btn-primary w-100">
                    <i class="fas fa-external-link-alt me-2"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Profile Modal -->
    <div class="mobile-modal" id="mobileProfileModal">
        <div class="mobile-modal-overlay"></div>
        <div class="mobile-modal-content">
            <div class="mobile-modal-header">
                <h5 class="mobile-modal-title">
                    <i class="fas fa-user me-2"></i>Profil Saya
                </h5>
                <button class="mobile-modal-close" id="closeProfileModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mobile-modal-body">
                <div class="mobile-profile-info">
                    @if (Auth::user()->foto && file_exists(storage_path('app/public/users/' . Auth::user()->foto)))
                        <img src="{{ asset('storage/users/' . Auth::user()->foto) }}"
                            alt="Foto {{ Auth::user()->name }}" class="mobile-profile-avatar">
                    @else
                        <div class="mobile-profile-avatar-placeholder">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <h6 class="mobile-profile-name">{{ Auth::user()->name }}</h6>
                    <p class="mobile-profile-email">{{ Auth::user()->email }}</p>
                </div>
                <div class="mobile-profile-menu">
                    <a href="{{ route('admin.profile.show') }}" class="mobile-menu-item">
                        <i class="fas fa-user me-3 text-primary"></i>
                        <span>Profile</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                    <div class="mobile-menu-item" id="mobileSettingsToggle">
                        <i class="fas fa-cog me-3 text-secondary"></i>
                        <span>Settings</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </div>
                    <div class="mobile-submenu" id="mobileSettingsSubmenu">
                        <div class="settings-item">
                            <div class="item-info">
                                <div class="item-title">Hide UMKM Registration</div>
                                <div class="item-description">Hide UMKM registration button from homepage</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="hideUmkmRegistrationMobile"
                                    onchange="toggleUmkmRegistration(this)">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="settings-item">
                            <div class="item-info">
                                <div class="item-title">Hide UMKM Menu</div>
                                <div class="item-description">Hide UMKM icon menu from homepage</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="hideUmkmMenuMobile" onchange="toggleUmkmMenu(this)">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-modal-footer">
                <form method="POST" action="{{ route('logout') }}" class="w-100">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src="{{ asset('js/admin/navigation.js') }}"></script>
</body>

</html>
