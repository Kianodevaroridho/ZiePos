<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ZiePos - @yield('title', 'Dashboard')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0F172A;
            --primary-light: #1E293B;
            --primary-dark: #020617;
            --secondary: #475569;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --info: #06B6D4;
            --sidebar-bg: #0F172A;
            --sidebar-hover: #1E293B;
            --body-bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --border-color: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Custom Modern Scrollbars */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.02);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, 0.15);
            border-radius: 99px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(15, 23, 42, 0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1E293B 0%, #0F172A 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .menu-label {
            padding: 0.5rem 1.5rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.35);
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .sidebar-menu .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1.5rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            margin: 2px 0;
        }

        .sidebar-menu .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.06);
            border-left-color: rgba(255, 255, 255, 0.3);
        }

        .sidebar-menu .nav-link.active {
            color: white;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.08), transparent);
            border-left-color: #FFFFFF;
        }

        .sidebar-menu .nav-link.logout-link {
            color: #EF4444 !important;
        }

        .sidebar-menu .nav-link.logout-link:hover {
            color: #F87171 !important;
            background-color: rgba(239, 68, 68, 0.08);
            border-left-color: #EF4444;
        }

        .sidebar-menu .nav-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .top-navbar .page-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .top-navbar .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .top-navbar .user-info {
            text-align: right;
        }

        .top-navbar .user-info .name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .top-navbar .user-info .role {
            font-size: 0.7rem;
            color: var(--text-secondary);
            text-transform: capitalize;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Content Area */
        .content-area {
            padding: 1.5rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
            background: var(--card-bg);
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 16px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            margin-top: 0.75rem;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669, var(--success));
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-danger {
            background: linear-gradient(135deg, #DC2626, var(--danger));
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-warning {
            background: linear-gradient(135deg, #D97706, var(--warning));
            border: none;
            border-radius: 10px;
            font-weight: 600;
            color: white;
        }

        .btn-warning:hover { color: white; }

        /* Tables */
        .table {
            font-size: 0.875rem;
        }

        .table thead th {
            background: #F8FAFC;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            padding: 0.75rem;
        }

        .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        /* Badge */
        .badge {
            border-radius: 8px;
            padding: 0.35rem 0.65rem;
            font-weight: 600;
            font-size: 0.7rem;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            padding: 0.6rem 0.9rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 0.35rem;
        }

        /* Alert */
        .alert {
            border: none;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: none;
            color: var(--text-primary);
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background: rgba(79, 70, 229, 0.08);
            color: var(--primary);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-color: var(--primary);
        }

        /* Input Group */
        .input-group-text {
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            font-size: 0.875rem;
            color: var(--text-secondary);
            background: #F8FAFC;
        }

        /* Form Switch */
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            border-color: var(--primary);
        }

        /* Button Light */
        .btn-light {
            border-radius: 10px;
            font-weight: 500;
            border: 1.5px solid var(--border-color);
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .btn-light:hover {
            background: #F1F5F9;
            border-color: #CBD5E1;
            color: var(--text-primary);
        }

        /* Outline Buttons */
        .btn-outline-primary {
            border-radius: 8px;
            border: 1.5px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .btn-outline-danger {
            border-radius: 8px;
            border: 1.5px solid var(--danger);
            color: var(--danger);
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-outline-danger:hover {
            background: var(--danger);
            border-color: var(--danger);
            transform: translateY(-1px);
        }

        /* Success Button hover */
        .btn-success:hover {
            background: linear-gradient(135deg, #047857, #059669);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #B91C1C, #DC2626);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #B45309, #D97706);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
            color: white;
        }

        /* Code Elements */
        code {
            background: rgba(15, 23, 42, 0.06);
            color: var(--primary);
            padding: 0.15rem 0.45rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Text Color Utilities */
        .text-primary { color: var(--primary) !important; }

        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h4 {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .page-header p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        /* Links */
        a {
            color: var(--primary);
            transition: color 0.2s ease;
        }

        a:hover {
            color: var(--primary-dark);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 2.5rem;
            color: #CBD5E1;
            margin-bottom: 0.75rem;
            display: block;
        }

        .empty-state p {
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        /* Responsive */
        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.4s ease forwards;
        }

        .fade-in-delay-1 { animation-delay: 0.1s; }
        .fade-in-delay-2 { animation-delay: 0.2s; }
        .fade-in-delay-3 { animation-delay: 0.3s; }

        /* SweetAlert ZiePos Theme */
        .swal2-container { z-index: 99999 !important; left: 0 !important; width: 100vw !important; margin-left: 0 !important; }
        .swal2-container.swal2-backdrop-show { background: rgba(15, 23, 42, 0.4) !important; backdrop-filter: blur(4px) !important; }
        .swal-ziepos { border-radius: 16px !important; font-family: 'Inter', sans-serif !important; padding: 2rem 1.5rem 1.5rem !important; box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important; }
        .swal-ziepos .swal2-icon { border-color: #0F172A !important; color: #0F172A !important; width: 52px !important; height: 52px !important; margin: 0 auto 1rem !important; }
        .swal-ziepos .swal2-icon .swal2-icon-content { font-size: 1.5rem !important; }
        .swal-ziepos .swal2-title { font-size: 1.15rem !important; font-weight: 700 !important; color: #0F172A !important; margin-top: 0 !important; }
        .swal-ziepos .swal2-html-container { font-size: 0.85rem !important; color: #64748B !important; text-align: center !important; margin-top: 0.5rem !important; }
        .swal-ziepos .swal2-actions { justify-content: center !important; gap: 10px !important; margin-top: 1.25rem !important; }
        .swal-ziepos .swal2-actions button { border-radius: 10px !important; font-weight: 600 !important; font-size: 0.85rem !important; padding: 0.55rem 1.5rem !important; min-width: 105px !important; transition: all 0.15s ease !important; box-shadow: none !important; }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-shop"></i>
            </div>
            <div>
                <h4>ZiePos</h4>
                <small>Point of Sales</small>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('pos.index') }}" class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>
                <span>Kasir (POS)</span>
            </a>

            <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i>
                <span>Transaksi</span>
            </a>

            @if(auth()->user()->isAdmin())
            <div class="menu-label">Manajemen</div>

            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Produk</span>
            </a>

            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Laporan</span>
            </a>
            @endif

            <div class="menu-label">Akun</div>

            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i>
                <span>Profil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" onclick="event.preventDefault(); confirmLogout();" class="nav-link logout-link">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </a>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="page-title mb-0">@yield('title', 'Dashboard')</h5>
            </div>
            <div class="user-menu">
                <div class="user-info d-none d-md-block">
                    <div class="name">{{ auth()->user()->name }}</div>
                    <div class="role">{{ auth()->user()->role }}</div>
                </div>
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-dismiss Alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000); // 3 seconds
            });
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function confirmLogout() {
        Swal.fire({
            title: 'Logout?',
            text: "Anda yakin ingin keluar dari sistem?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0F172A',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: { popup: 'swal-ziepos' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
    </script>

    @stack('scripts')
</body>
</html>
