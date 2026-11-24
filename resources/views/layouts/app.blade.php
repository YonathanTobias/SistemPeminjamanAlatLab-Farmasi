<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pengaturan->nama_sistem ?? 'Sistem Peminjaman Alat Lab' }} - {{ $pengaturan->nama_prodi ?? 'STIKES Panti Waluya' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset($pengaturan->logo_path ?? 'images/logo-stikes.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons 1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Custom STIKES Lab CSS (External & Browser-Cached) -->
    <link rel="stylesheet" href="{{ asset('css/stikes-lab.css') }}?v={{ file_exists(public_path('css/stikes-lab.css')) ? filemtime(public_path('css/stikes-lab.css')) : time() }}">

    <!-- Dynamic Theme Palette per Program Studi -->
    @php
        $theme = $pengaturan->theme_colors ?? [
            'name' => 'blue',
            'primary' => '#0284c7',
            'primary_dark' => '#0369a1',
            'primary_light' => '#e0f2fe',
            'gradient' => 'linear-gradient(135deg, #082f49 0%, #0369a1 40%, #0284c7 80%, #38bdf8 100%)',
            'navbar_bg' => 'rgba(15, 23, 42, 0.96)',
            'navbar_border' => 'rgba(2, 132, 199, 0.2)',
            'badge_soft' => 'rgba(2, 132, 199, 0.15)',
        ];
    @endphp
    <style>
        :root {
            --primary: {{ $theme['primary'] }};
            --primary-dark: {{ $theme['primary_dark'] }};
            --primary-light: {{ $theme['primary_light'] }};
        }
        .navbar-custom {
            position: sticky !important;
            top: 0 !important;
            z-index: 1030 !important;
            background: {{ $theme['navbar_bg'] }} !important;
            border-bottom: 1px solid {{ $theme['navbar_border'] }} !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.25) !important;
        }
        .footer-custom {
            background: {{ $theme['navbar_bg'] }} !important;
            border-top: 1px solid {{ $theme['navbar_border'] }} !important;
            padding: 2.5rem 0;
            margin-top: auto;
        }
        .hero-banner-prodi {
            background: {{ $theme['gradient'] }} !important;
            border: 1px solid {{ $theme['navbar_border'] }} !important;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.35) !important;
        }
        .auth-brand-side {
            background: {{ $theme['gradient'] }} !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, {{ $theme['primary'] }} 0%, {{ $theme['primary_dark'] }} 100%) !important;
            border-color: {{ $theme['primary_dark'] }} !important;
            color: {{ $theme['btn_text'] ?? '#0f172a' }} !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 14px rgba(234, 179, 8, 0.3) !important;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, {{ $theme['primary_dark'] }} 0%, #ca8a04 100%) !important;
            border-color: #ca8a04 !important;
            color: {{ $theme['btn_text'] ?? '#0f172a' }} !important;
            box-shadow: 0 6px 18px rgba(234, 179, 8, 0.45) !important;
        }
        .btn-outline-primary {
            color: {{ $theme['text_primary'] ?? $theme['primary'] }} !important;
            border-color: {{ $theme['primary'] }} !important;
            font-weight: 600 !important;
        }
        .btn-outline-primary:hover {
            background-color: {{ $theme['primary'] }} !important;
            border-color: {{ $theme['primary'] }} !important;
            color: #0f172a !important;
        }
        .badge-soft-primary {
            background-color: {{ $theme['badge_soft'] }} !important;
            border: 1px solid {{ $theme['navbar_border'] }} !important;
            color: {{ $theme['text_primary'] ?? $theme['primary'] }} !important;
            font-weight: 600 !important;
        }
        .text-primary {
            color: {{ $theme['text_primary'] ?? $theme['primary'] }} !important;
        }
        .nav-link-custom {
            color: #94a3b8 !important;
        }
        .nav-link-custom:hover {
            color: {{ $theme['primary'] }} !important;
            background: rgba(255, 255, 255, 0.08) !important;
        }
        .nav-link-custom.active {
            background: {{ $theme['badge_soft'] }} !important;
            border: 1px solid {{ $theme['primary'] }} !important;
            color: {{ $theme['primary'] }} !important;
            font-weight: 700 !important;
        }
        .page-item.active .page-link {
            background-color: {{ $theme['primary'] }} !important;
            border-color: {{ $theme['primary_dark'] ?? $theme['primary'] }} !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            box-shadow: 0 2px 8px rgba(234, 179, 8, 0.35) !important;
        }
        .page-link {
            color: #374151;
        }
        .page-link:hover {
            color: #000000;
            background-color: {{ $theme['primary_light'] ?? '#FEF9C3' }};
            border-color: {{ $theme['primary_dark'] ?? $theme['primary'] }};
        }

        /* --- Seamless Dark Mode Overrides --- */
        [data-bs-theme="dark"] .text-primary {
            color: {{ $theme['primary'] }} !important;
        }
        [data-bs-theme="dark"] .badge-soft-primary {
            background-color: {{ $theme['badge_soft'] }} !important;
            border-color: rgba(250, 204, 21, 0.4) !important;
            color: {{ $theme['primary'] }} !important;
        }
        [data-bs-theme="dark"] .btn-outline-primary {
            color: {{ $theme['primary'] }} !important;
            border-color: {{ $theme['primary'] }} !important;
        }
        [data-bs-theme="dark"] .btn-outline-primary:hover {
            background-color: {{ $theme['primary'] }} !important;
            color: #0f172a !important;
        }
        [data-bs-theme="dark"] .page-link {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .page-link:hover {
            background-color: #334155 !important;
            color: {{ $theme['primary'] }} !important;
        }
        [data-bs-theme="dark"] .page-item.active .page-link {
            background-color: {{ $theme['primary'] }} !important;
            border-color: {{ $theme['primary'] }} !important;
            color: #0f172a !important;
        }
        [data-bs-theme="dark"] .card-alat-img {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }

        /* ========================================================
           ANTI-FAINT & HIGH-CONTRAST TYPOGRAPHY SYSTEM
           Memastikan semua font tajam, jelas terbaca, tidak samar
           ======================================================== */
        body {
            color: #1e293b;
        }
        .text-muted {
            color: #475569 !important;
            font-weight: 500 !important;
        }
        .text-secondary {
            color: #334155 !important;
            font-weight: 600 !important;
        }
        .text-white-50 {
            color: rgba(255, 255, 255, 0.88) !important;
        }
        small, .small {
            font-weight: 500;
        }
        .card-title {
            color: #0f172a !important;
        }
        p {
            color: #334155;
        }
        label, .form-label {
            color: #1e293b !important;
            font-weight: 600 !important;
        }
        .table th {
            color: #0f172a !important;
            font-weight: 700 !important;
        }
        .table td {
            color: #1e293b !important;
        }
        .badge.bg-light {
            background-color: #f1f5f9 !important;
            color: #1e293b !important;
            border-color: #cbd5e1 !important;
            font-weight: 600 !important;
        }
        .btn-outline-secondary {
            color: #1e293b !important;
            border-color: #cbd5e1 !important;
            font-weight: 600 !important;
        }
        .btn-outline-secondary:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #94a3b8 !important;
        }
        ::placeholder {
            color: #64748b !important;
            opacity: 1 !important;
        }

        /* ========================================================
           FLOATING CIRCULAR CART BUTTON (POJOK KANAN BAWAH)
           ======================================================== */
        .floating-cart-btn {
            position: fixed !important;
            bottom: 28px !important;
            right: 28px !important;
            width: 62px !important;
            height: 62px !important;
            border-radius: 50% !important;
            z-index: 1045 !important;
            box-shadow: 0 10px 25px -5px rgba(234, 179, 8, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.15) !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border: 2px solid rgba(255, 255, 255, 0.7) !important;
            padding: 0 !important;
            cursor: pointer;
        }
        .floating-cart-btn:hover {
            transform: scale(1.1) translateY(-4px) !important;
            box-shadow: 0 16px 32px -4px rgba(234, 179, 8, 0.65), 0 12px 14px -5px rgba(0, 0, 0, 0.2) !important;
        }
        .floating-cart-btn:active {
            transform: scale(0.95) !important;
        }
        .floating-cart-btn .badge-pop {
            animation: badgePop 0.3s ease;
        }
        @keyframes badgePop {
            0% { transform: translate(50%, -50%) scale(1); }
            50% { transform: translate(50%, -50%) scale(1.35); }
            100% { transform: translate(50%, -50%) scale(1); }
        }
        @media (max-width: 575.98px) {
            .floating-cart-btn {
                bottom: 20px !important;
                right: 20px !important;
                width: 54px !important;
                height: 54px !important;
            }
        }

        /* Subtle badges with high contrast */
        .kategori-badge {
            background-color: #f1f5f9;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            font-weight: 600;
            font-size: 0.74rem;
        }
        .sub-unit-text {
            color: #475569;
            font-weight: 500;
        }
        .stock-box-text {
            color: #1e293b;
        }
        .stock-box-total {
            color: #475569;
        }
        .bg-success-subtle {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            font-weight: 600 !important;
        }
        .bg-warning-subtle {
            background-color: #fef9c3 !important;
            color: #a16207 !important;
            font-weight: 600 !important;
        }
        .bg-danger-subtle {
            background-color: #fee2e2 !important;
            color: #b91c1c !important;
            font-weight: 600 !important;
        }
        .bg-info-subtle {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            font-weight: 600 !important;
        }
        .bg-primary-subtle {
            background-color: #fef08a !important;
            color: #854d0e !important;
            font-weight: 600 !important;
        }

        /* Pagination typography */
        nav[role="navigation"] p,
        nav[role="navigation"] span,
        .pagination + div p,
        div:has(> .pagination) p {
            color: #1e293b !important;
            font-weight: 600 !important;
        }

        /* --- Dark Mode High-Contrast Rules --- */
        [data-bs-theme="dark"] body {
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] p {
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .text-muted {
            color: #cbd5e1 !important;
            font-weight: 500 !important;
        }
        [data-bs-theme="dark"] .text-secondary {
            color: #f1f5f9 !important;
            font-weight: 600 !important;
        }
        [data-bs-theme="dark"] .card-title,
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] strong,
        [data-bs-theme="dark"] b {
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .badge.bg-light {
            background-color: #334155 !important;
            color: #f8fafc !important;
            border-color: #475569 !important;
        }
        [data-bs-theme="dark"] .table th {
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .table td {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .form-label {
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            color: #ffffff !important;
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] ::placeholder {
            color: #94a3b8 !important;
            opacity: 1 !important;
        }
        [data-bs-theme="dark"] .kategori-badge {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] .sub-unit-text {
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .stock-box-text {
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .stock-box-total {
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .badge-soft-success {
            background-color: rgba(34, 197, 94, 0.2) !important;
            color: #4ade80 !important;
            border-color: rgba(34, 197, 94, 0.4) !important;
        }
        [data-bs-theme="dark"] .badge-soft-warning {
            background-color: rgba(234, 179, 8, 0.2) !important;
            color: #facc15 !important;
            border-color: rgba(234, 179, 8, 0.4) !important;
        }
        [data-bs-theme="dark"] .badge-soft-danger {
            background-color: rgba(239, 68, 68, 0.2) !important;
            color: #f87171 !important;
            border-color: rgba(239, 68, 68, 0.4) !important;
        }
        [data-bs-theme="dark"] .badge-soft-secondary {
            background-color: rgba(148, 163, 184, 0.2) !important;
            color: #f1f5f9 !important;
            border-color: rgba(148, 163, 184, 0.4) !important;
        }
        [data-bs-theme="dark"] .bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.22) !important;
            color: #86efac !important;
        }
        [data-bs-theme="dark"] .bg-warning-subtle {
            background-color: rgba(234, 179, 8, 0.22) !important;
            color: #fde047 !important;
        }
        [data-bs-theme="dark"] .bg-danger-subtle {
            background-color: rgba(239, 68, 68, 0.22) !important;
            color: #fca5a5 !important;
        }
        [data-bs-theme="dark"] .bg-info-subtle {
            background-color: rgba(14, 165, 233, 0.22) !important;
            color: #7dd3fc !important;
        }
        [data-bs-theme="dark"] .bg-primary-subtle {
            background-color: rgba(250, 204, 21, 0.22) !important;
            color: #fde047 !important;
        }
        [data-bs-theme="dark"] .btn-outline-secondary {
            color: #e2e8f0 !important;
            border-color: #475569 !important;
        }
        [data-bs-theme="dark"] .btn-outline-secondary:hover {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] nav[role="navigation"] p,
        [data-bs-theme="dark"] nav[role="navigation"] span,
        [data-bs-theme="dark"] .pagination + div p,
        [data-bs-theme="dark"] div:has(> .pagination) p {
            color: #f1f5f9 !important;
            font-weight: 600 !important;
        }
        [data-bs-theme="dark"] .modal-content {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] .modal-header,
        [data-bs-theme="dark"] .modal-footer {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] .modal-title {
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .floating-cart-btn {
            box-shadow: 0 10px 25px -5px rgba(250, 204, 21, 0.35), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
        }
        [data-bs-theme="dark"] .floating-cart-btn:hover {
            box-shadow: 0 16px 32px -4px rgba(250, 204, 21, 0.5), 0 12px 14px -5px rgba(0, 0, 0, 0.6) !important;
        }

        @if(($theme['name'] ?? '') === 'yellow')
        .hero-banner-prodi,
        .auth-brand-side {
            color: #0f172a !important;
            border: 1px solid rgba(234, 179, 8, 0.45) !important;
        }
        .hero-banner-prodi {
            box-shadow: 0 10px 30px -5px rgba(234, 179, 8, 0.25) !important;
        }
        .hero-banner-prodi h1,
        .hero-banner-prodi h2,
        .hero-banner-prodi .h2,
        .hero-banner-prodi .display-6,
        .hero-banner-prodi .text-white,
        .auth-brand-side h3,
        .auth-brand-side h4,
        .auth-brand-side h5,
        .auth-brand-side .text-white {
            color: #0f172a !important;
        }
        .hero-banner-prodi p,
        .auth-brand-side p,
        .auth-brand-side span {
            color: #1e293b !important;
        }
        .auth-brand-side .text-white-50 {
            color: #334155 !important;
            font-weight: 600 !important;
        }
        @endif

        /* Dark mode for login / register card */
        [data-bs-theme="dark"] .auth-split-card {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] .auth-split-card .col-lg-6:not(.auth-brand-side) {
            background-color: #0f172a !important;
        }
        [data-bs-theme="dark"] .auth-split-card h4 {
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .auth-split-card .form-control {
            background-color: #1e293b !important;
            color: #ffffff !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] .auth-split-card .input-group-text {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Modern Sticky Glass Navbar -->
        <nav class="navbar navbar-expand-xl navbar-dark navbar-custom sticky-top">
            <div class="container-fluid px-lg-4">
                <a class="navbar-brand d-flex align-items-center me-3" href="{{ url('/') }}" title="{{ $pengaturan->nama_sistem ?? 'SIM-LAB STIKES' }}">
                    <img src="{{ asset($pengaturan->logo_path ?? 'images/logo-stikes.png') }}" alt="Logo" height="38" class="me-2 flex-shrink-0" style="object-fit: contain;">
                    <div>
                        <div class="fw-bold lh-1 text-white" style="font-size: 0.92rem;">SIM-LAB STIKES</div>
                        <small class="d-block" style="font-size: 0.68rem; font-weight: 700; letter-spacing: 0.05em; color: rgba(255, 255, 255, 0.88); white-space: nowrap;">{{ strtoupper($pengaturan->nama_prodi ?? 'STIKES PANTI WALUYA') }}</small>
                    </div>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Nav (Public & Admin links) -->
                    <ul class="navbar-nav me-auto mb-2 mb-xl-0 gap-1 align-items-xl-center">
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('lab.katalog') ? 'active' : '' }}" href="{{ route('lab.katalog') }}">
                                <i class="bi bi-boxes"></i> Alat Lab
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('lab.ruangan') ? 'active' : '' }}" href="{{ route('lab.ruangan') }}">
                                <i class="bi bi-door-open"></i> Ruangan Lab
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom {{ request()->routeIs('lab.lacak') ? 'active' : '' }}" href="{{ route('lab.lacak') }}">
                                <i class="bi bi-search-heart"></i> Lacak Status
                            </a>
                        </li>
                        @auth
                            <!-- Dropdown Menu Peminjaman -->
                            <li class="nav-item dropdown">
                                <a class="nav-link-custom dropdown-toggle {{ request()->routeIs('admin.peminjaman.*') || request()->routeIs('admin.ruangan.peminjaman') || request()->routeIs('admin.lab.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-clipboard-check"></i> Peminjaman
                                </a>
                                <ul class="dropdown-menu shadow-lg border-0 rounded-3 mt-1 p-2">
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 {{ request()->routeIs('admin.peminjaman.*') || request()->routeIs('admin.lab.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.peminjaman.index') }}">
                                            <i class="bi bi-box-seam"></i> Peminjaman Alat
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 {{ request()->routeIs('admin.ruangan.peminjaman') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.ruangan.peminjaman') }}">
                                            <i class="bi bi-door-open"></i> Peminjaman Ruangan
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Dropdown Menu Inventaris -->
                            <li class="nav-item dropdown">
                                <a class="nav-link-custom dropdown-toggle {{ request()->routeIs('admin.alat.*') || request()->routeIs('admin.kategori.*') || request()->routeIs('admin.ruangan.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-box-seam"></i> Inventaris
                                </a>
                                <ul class="dropdown-menu shadow-lg border-0 rounded-3 mt-1 p-2">
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 {{ request()->routeIs('admin.alat.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.alat.index') }}">
                                            <i class="bi bi-boxes"></i> Daftar Peralatan Lab
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 {{ request()->routeIs('admin.ruangan.index') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.ruangan.index') }}">
                                            <i class="bi bi-building"></i> Data Ruangan Lab
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 {{ request()->routeIs('admin.kategori.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.kategori.index') }}">
                                            <i class="bi bi-tags"></i> Kategori Praktikum
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link-custom {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="{{ route('admin.laporan.index') }}">
                                    <i class="bi bi-file-earmark-bar-graph"></i> Laporan
                                </a>
                            </li>

                            <!-- Dropdown Menu Pengaturan & Pengguna -->
                            <li class="nav-item dropdown">
                                <a class="nav-link-custom dropdown-toggle {{ request()->routeIs('admin.pengaturan.*') || request()->routeIs('admin.users.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear-fill"></i> Pengaturan
                                </a>
                                <ul class="dropdown-menu shadow-lg border-0 rounded-3 mt-1 p-2">
                                    <li>
                                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 {{ request()->routeIs('admin.pengaturan.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.pengaturan.index') }}">
                                            <i class="bi bi-sliders"></i> Profil & Tema Lab
                                        </a>
                                    </li>
                                    @if((Auth::user()->role ?? '') === 'admin_it')
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 {{ request()->routeIs('admin.users.*') ? 'fw-bold text-primary' : '' }}" href="{{ route('admin.users.index') }}">
                                                <i class="bi bi-people-fill"></i> Kelola Pengguna
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Nav (Theme Toggle, Auth & Profile) -->
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                        <!-- Dark / Light Mode Toggle Button -->
                        <li class="nav-item">
                            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 d-flex align-items-center gap-2 border-opacity-25" onclick="toggleTheme()" title="Ubah Tema Gelap / Terang">
                                <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                                <span class="small d-none d-lg-inline">Mode</span>
                            </button>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-primary btn-sm px-3 rounded-pill shadow-xs" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right"></i> Login Laboran
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="{{ (Auth::user()->role ?? '') === 'admin_it' ? 'bg-danger' : 'bg-primary' }} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.85rem; font-weight: 700;">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-semibold">{{ Auth::user()->name }}</span>
                                        <span class="badge {{ (Auth::user()->role ?? '') === 'admin_it' ? 'bg-danger' : 'bg-primary' }} rounded-pill" style="font-size: 0.65rem; font-weight: 700;">
                                            {{ (Auth::user()->role ?? '') === 'admin_it' ? 'Admin IT' : 'Laboran' }}
                                        </span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2" aria-labelledby="navbarDropdown">
                                    <div class="px-3 py-2 border-bottom mb-1">
                                        <div class="small text-muted">Masuk sebagai:</div>
                                        <div class="fw-bold text-dark">{{ Auth::user()->email }}</div>
                                        <div class="mt-1">
                                            <span class="badge {{ (Auth::user()->role ?? '') === 'admin_it' ? 'bg-danger' : 'bg-primary' }}">
                                                {{ (Auth::user()->role ?? '') === 'admin_it' ? 'Hak Akses: Admin IT' : 'Hak Akses: Petugas Laboran' }}
                                            </span>
                                        </div>
                                    </div>
                                    <a class="dropdown-item rounded-3 py-2 text-danger d-flex align-items-center gap-2" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-grow-1 py-4">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm rounded-4 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <div class="flex-grow-1 fw-medium">{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm rounded-4 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                        <div class="flex-grow-1 fw-medium">{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm rounded-4 mb-4" role="alert">
                        <i class="bi bi-info-circle-fill text-info fs-5"></i>
                        <div class="flex-grow-1 fw-medium">{{ session('info') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Modern Footer -->
        <footer class="footer-custom">
            <div class="container">
                <div class="row align-items-center gy-3">
                    <div class="col-md-7 text-center text-md-start d-flex align-items-center gap-3 justify-content-center justify-content-md-start">
                        <img src="{{ asset($pengaturan->logo_path ?? 'images/logo-stikes.png') }}" alt="Logo" height="48" style="object-fit: contain;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge badge-soft-primary px-3 py-1 rounded-pill small fw-semibold">
                                    <i class="bi bi-hospital"></i> {{ $pengaturan->unit_laboratorium ?? 'Unit Laboratorium' }}
                                </span>
                            </div>
                            <p class="mb-0" style="color: rgba(255, 255, 255, 0.88); font-size: 0.85rem;">{{ $pengaturan->nama_institusi ?? 'STIKES Panti Waluya Malang' }} &copy; {{ date('Y') }}. {{ $pengaturan->nama_sistem ?? 'Sistem Informasi Laboratorium' }}.</p>
                        </div>
                    </div>
                    <div class="col-md-5 text-center text-md-end">
                        <span class="small" style="color: rgba(255, 255, 255, 0.88);">{{ $pengaturan->alamat_institusi ?? 'Jl. Yulius Usman No.62, Kasin, Klojen, Kota Malang' }} &bull; Telp: {{ $pengaturan->kontak_lab ?? '(0341) 369003' }}</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- QRCode.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- HTML5-QRCode Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- Custom App JS -->
    <script src="{{ asset('js/stikes-lab.js') }}"></script>
    @stack('scripts')
</body>
</html>