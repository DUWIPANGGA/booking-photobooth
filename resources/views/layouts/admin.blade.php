<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Vibes Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- HAPUS Tailwind CDN ini -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #7B2D3E;
            --primary-dark: #5C1F2D;
            --bg-light: #F5EDE8;
            --sidebar-bg: #80404D;
            --white: #FFFFFF;
            --text-dark: #3D1A24;
            --border-color: #E8D5D0;
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #F8F9FA;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
        }

        .sidebar-header {
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-family: 'Great Vibes', cursive;
            font-size: 1.8rem;
        }

        .sidebar-logo {
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .sidebar-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 30px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-item i {
            width: 24px;
            font-size: 1.2rem;
        }

        /* Content Area */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: 0.3s;
        }

        @media (max-width: 1024px) {
            .sidebar {
                left: -280px;
                z-index: 2000;
                transition: 0.3s;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1500;
            }

            .overlay.active {
                display: block;
            }
        }

        .top-navbar {
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-toggler {
            display: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .sidebar-toggler {
                display: block;
            }

            .top-navbar {
                padding: 0 15px;
            }
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--primary-dark);
            font-weight: 700;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            position: relative;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #ddd;
        }

        .admin-info {
            text-align: right;
        }

        .admin-name {
            font-size: 0.9rem;
            font-weight: 700;
            color: #333;
        }

        .admin-role {
            font-size: 0.75rem;
            color: #888;
            display: block;
        }

        #admin-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 220px;
            margin-top: 15px;
            padding: 10px;
            z-index: 1000;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .logout-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            font-size: 1.1rem;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            border-radius: 10px;
        }

        .logout-item:hover {
            background: #f9f9f9;
        }

        .logout-box {
            width: 44px;
            height: 44px;
            border: 1.5px solid #ddd;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-box i {
            color: #E74C3C;
            font-size: 1.2rem;
        }

        .content-body {
            padding: 20px;
        }

        @media (min-width: 768px) {
            .content-body {
                padding: 40px;
            }
        }

        /* Components */
        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="https://ui-avatars.com/api/?name=V&background=fff&color=7B2D3E" alt="Logo">
            </div>
            <span>Vibes Studio</span>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}"
                class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Beranda
            </a>
            <a href="{{ route('admin.galeri.index') }}"
                class="menu-item {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <i class="fas fa-image"></i> Manajemen Galeri
            </a>
            <a href="{{ route('admin.paket.index') }}"
                class="menu-item {{ request()->routeIs('admin.paket.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Manajemen Paket
            </a>
            <a href="{{ route('admin.booking.index') }}"
                class="menu-item {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Manajemen Booking
            </a>
            <a href="{{ route('admin.profile') }}"
                class="menu-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profile
            </a>
        </div>
    </div>

    <div class="overlay" id="sidebar-overlay"></div>

    <div class="main-content">
        <div class="top-navbar">
            <div class="navbar-left">
                <div class="sidebar-toggler" id="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="page-title">@yield('page_title', 'Beranda')</div>
            </div>
            <div class="admin-profile" id="admin-profile-toggle">
                <div class="admin-info">
                    <span class="admin-name">{{ auth()->user()->name }}</span>
                    <span class="admin-role">Admin</span>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=E8D5D0&color=7B2D3E"
                    alt="Avatar" class="admin-avatar">

                <div id="admin-dropdown">
                    <a href="{{ route('admin.profile') }}"
                        style="display: flex; align-items: center; gap: 15px; padding: 12px 15px; color: #333; text-decoration: none; font-size: 1.1rem; border-radius: 10px;">
                        <div class="logout-box" style="border-color: #ddd;"><i class="fas fa-user"
                                style="color: #8B4513;"></i></div>
                        <span>Profil</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-item">
                            <div class="logout-box"><i class="fas fa-sign-out-alt"></i></div>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
    <script>
        const profileToggle = document.getElementById('admin-profile-toggle');
        const adminDropdown = document.getElementById('admin-dropdown');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        if (profileToggle) {
            profileToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                adminDropdown.style.display = adminDropdown.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', () => {
                adminDropdown.style.display = 'none';
            });
        }
    </script>
</body>

</html>
