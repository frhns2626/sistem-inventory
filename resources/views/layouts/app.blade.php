<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 text-gray-950 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIMBA') | Sistem Informasi Manajemen Barang</title>

    {{-- Favicon SIMBA --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=1">

    {{-- Typography: Inter & JetBrains Mono --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN Manual --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                        mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        primary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            950: '#451a03',
                        }
                    },
                    boxShadow: {
                        'xs': '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Filament v3 standard scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        @media (min-width: 1024px) {
            #sidebar-wrapper {
                transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }
            #sidebar-wrapper.desktop-collapsed {
                margin-left: -16rem !important; /* 16rem = w-64 */
            }
            html.sidebar-collapsed-init #sidebar-wrapper {
                margin-left: -16rem !important;
                transition: none !important;
            }
        }
    </style>

    <script>
        if (window.innerWidth >= 1024 && localStorage.getItem('simba_sidebar_collapsed') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed-init');
        }
    </script>

    @stack('styles')
</head>
<body class="h-full flex overflow-hidden bg-gray-50 text-gray-950 selection:bg-amber-500 selection:text-white font-sans">

    {{-- Mobile Sidebar Backdrop --}}
    <div id="sidebar-backdrop" class="fixed inset-0 bg-gray-950/50 z-30 hidden lg:hidden backdrop-blur-xs transition-opacity duration-200"></div>

    {{-- SIDEBAR CONTAINER --}}
    <div id="sidebar-wrapper" class="fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shrink-0 transition-transform duration-200 ease-in-out">
        @include('layouts.partials.sidebar')
    </div>

    {{-- MAIN CONTENT WRAPPER --}}
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">

        {{-- Top Bar Header --}}
        @include('layouts.partials.navbar')

        {{-- Main Page Canvas --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">

            {{-- Alerts / Flash notifications --}}
            @include('layouts.partials.alerts')

            {{-- Main Injected Content --}}
            @yield('content')
            {{ $slot ?? '' }}

        </main>

        {{-- Footer --}}
        @include('layouts.partials.footer')

    </div>

    {{-- Lightweight Vanilla Interaction JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebar-toggle-btn') || document.getElementById('mobile-toggle-btn');
            const iconLeft = document.getElementById('icon-sidebar-left');
            const iconRight = document.getElementById('icon-sidebar-right');
            const closeBtn = document.getElementById('sidebar-close-btn');
            const sidebarWrapper = document.getElementById('sidebar-wrapper');
            const backdrop = document.getElementById('sidebar-backdrop');

            const userMenuBtn = document.getElementById('user-menu-btn');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');

            const isDesktop = () => window.innerWidth >= 1024;

            // Inisialisasi status collapse desktop dari localStorage
            if (isDesktop() && localStorage.getItem('simba_sidebar_collapsed') === 'true') {
                if (sidebarWrapper) sidebarWrapper.classList.add('desktop-collapsed');
            }
            // Hapus class anti-flicker setelah DOM siap
            document.documentElement.classList.remove('sidebar-collapsed-init');

            function isSidebarOpen() {
                if (isDesktop()) {
                    return sidebarWrapper && !sidebarWrapper.classList.contains('desktop-collapsed');
                } else {
                    return sidebarWrapper && !sidebarWrapper.classList.contains('-translate-x-full');
                }
            }

            const topbarBrand = document.getElementById('topbar-collapsed-brand');

            function updateSidebarToggleIcon() {
                const open = isSidebarOpen();
                if (iconLeft && iconRight) {
                    if (open) {
                        // Saat terbuka: tampilkan ikon tutup
                        iconLeft.classList.remove('hidden');
                        iconRight.classList.add('hidden');
                        if (toggleBtn) toggleBtn.setAttribute('title', 'Tutup Sidebar (Ctrl+B)');
                        if (topbarBrand) {
                            topbarBrand.classList.add('hidden');
                            topbarBrand.classList.remove('flex');
                        }
                    } else {
                        // Saat tertutup: tampilkan ikon buka & brand logo di header
                        iconLeft.classList.add('hidden');
                        iconRight.classList.remove('hidden');
                        if (toggleBtn) toggleBtn.setAttribute('title', 'Buka Sidebar (Ctrl+B)');
                        if (topbarBrand) {
                            topbarBrand.classList.remove('hidden');
                            topbarBrand.classList.add('flex');
                        }
                    }
                }
            }

            function openMobileSidebar() {
                if (sidebarWrapper) sidebarWrapper.classList.remove('-translate-x-full');
                if (backdrop) backdrop.classList.remove('hidden');
                updateSidebarToggleIcon();
            }

            function closeMobileSidebar() {
                if (sidebarWrapper) sidebarWrapper.classList.add('-translate-x-full');
                if (backdrop) backdrop.classList.add('hidden');
                updateSidebarToggleIcon();
            }

            function toggleDesktopSidebar() {
                if (!sidebarWrapper) return;
                const isCollapsed = sidebarWrapper.classList.toggle('desktop-collapsed');
                localStorage.setItem('simba_sidebar_collapsed', isCollapsed ? 'true' : 'false');
                updateSidebarToggleIcon();
            }

            function handleToggle() {
                if (isDesktop()) {
                    toggleDesktopSidebar();
                } else {
                    if (sidebarWrapper && sidebarWrapper.classList.contains('-translate-x-full')) {
                        openMobileSidebar();
                    } else {
                        closeMobileSidebar();
                    }
                }
            }

            function handleClose() {
                if (isDesktop()) {
                    if (sidebarWrapper) {
                        sidebarWrapper.classList.add('desktop-collapsed');
                        localStorage.setItem('simba_sidebar_collapsed', 'true');
                        updateSidebarToggleIcon();
                    }
                } else {
                    closeMobileSidebar();
                }
            }

            // Inisialisasi ikon saat pertama kali dibuka
            updateSidebarToggleIcon();

            // Dengarkan perubahan ukuran layar agar status ikon tetap sinkron
            window.addEventListener('resize', updateSidebarToggleIcon);

            if (toggleBtn) toggleBtn.addEventListener('click', handleToggle);
            if (closeBtn) closeBtn.addEventListener('click', handleClose);
            if (backdrop) backdrop.addEventListener('click', closeMobileSidebar);

            // Shortcut Keyboard: Ctrl+B atau Cmd+B untuk toggle sidebar
            document.addEventListener('keydown', function (e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
                    e.preventDefault();
                    handleToggle();
                }
            });

            // User dropdown
            if (userMenuBtn && userMenuDropdown) {
                userMenuBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    userMenuDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function (e) {
                    if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                        userMenuDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
