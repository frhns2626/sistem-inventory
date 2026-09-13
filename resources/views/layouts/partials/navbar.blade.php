<header class="bg-white border-b border-gray-200/80 sticky top-0 z-20 h-16">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-full gap-4">
        
        {{-- Left: Sidebar Toggle Button & Brand (tampil saat sidebar tertutup) --}}
        <div class="flex items-center gap-2 shrink-0">
            {{-- Sidebar Toggle Button --}}
            <button type="button" id="sidebar-toggle-btn" 
                    class="p-2 -ml-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 transition duration-150 cursor-pointer" 
                    title="Toggle Sidebar (Ctrl+B)" 
                    aria-label="Toggle sidebar">
                {{-- Heroicon Outline: bars-3 (open state) --}}
                <svg id="icon-sidebar-left" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>

                {{-- Heroicon Outline: bars-3-bottom-left (collapsed state) --}}
                <svg id="icon-sidebar-right" class="w-5 h-5 hidden transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h8.25" />
                </svg>
            </button>

            {{-- Collapsed Brand Logo (Tampil saat sidebar tertutup atau di mobile) --}}
            <a href="{{ url('/') }}" id="topbar-collapsed-brand" class="hidden items-center gap-2.5 ml-1">
                <div class="w-7 h-7 rounded-lg bg-amber-500 text-white font-bold flex items-center justify-center text-xs tracking-tight shadow-xs ring-1 ring-amber-600/30">
                    SB
                </div>
                <span class="text-sm font-bold text-gray-950 tracking-tight">SIMBA</span>
            </a>
        </div>

        {{-- Right: Notifications, User Profile & Role Switcher --}}
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">

            {{-- Notification Bell Icon --}}
            <button type="button" 
                    class="relative p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 transition duration-150 cursor-pointer" 
                    title="Notifikasi Sistem"
                    aria-label="Notifikasi">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
            </button>

            <div class="h-5 w-px bg-gray-200 mx-0.5"></div>

            {{-- User Profile & Role Switcher Menu --}}
            <div class="relative">
                @php
                    $user = auth()->user();
                    $userName = $user->name ?? 'Administrator';
                    $initials = strtoupper(substr($userName, 0, 2));
                    $currentRole = auth()->check() && $user->roles->isNotEmpty() 
                        ? $user->roles->pluck('name')->first() 
                        : 'superadmin';

                    $availableRoles = [
                        'superadmin'        => 'Superadmin (Akses Penuh)',
                        'employee'          => 'Employee (Staf Pemohon)',
                        'dept_head'         => 'Dept Head (Approver)',
                        'purchasing'        => 'Purchasing (Pengadaan)',
                        'warehouse_staff'   => 'Warehouse Staff (Gudang)',
                        'warehouse_manager' => 'Warehouse Manager',
                        'finance'           => 'Finance (Keuangan)',
                        'auditor'           => 'Internal Auditor',
                    ];
                @endphp

                <button type="button" id="user-menu-btn" 
                        class="flex items-center gap-2.5 p-1 rounded-lg hover:bg-gray-100 transition duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 cursor-pointer">
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white font-semibold flex items-center justify-center text-xs tracking-tight shadow-xs ring-2 ring-amber-500/20 shrink-0">
                        {{ $initials }}
                    </div>

                    <div class="hidden md:flex flex-col text-left">
                        <span class="text-xs font-semibold text-gray-900 leading-tight max-w-[180px] lg:max-w-[220px] truncate">{{ $userName }}</span>
                        <span class="text-[10px] text-amber-700 font-semibold tracking-wide uppercase leading-none mt-0.5">
                            {{ str_replace('_', ' ', $currentRole) }}
                        </span>
                    </div>

                    <svg class="w-4 h-4 text-gray-400 hidden md:block shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                {{-- User Dropdown with Role Switcher --}}
                <div id="user-menu-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg ring-1 ring-gray-950/5 py-1.5 z-50 text-xs divide-y divide-gray-100">
                    <div class="px-4 py-3">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 font-mono">Masuk sebagai</p>
                        <p class="font-semibold text-gray-950 truncate mt-0.5 text-sm">{{ $userName }}</p>
                        <div class="mt-1.5 inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span class="capitalize">{{ str_replace('_', ' ', $currentRole) }}</span>
                        </div>
                    </div>

                    <div class="px-3.5 py-2.5 bg-gray-50/60">
                        <p class="text-[10px] font-semibold text-gray-500 uppercase font-mono tracking-wider flex items-center gap-1.5 mb-2">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Ganti Peran (Dev Test):
                        </p>
                        <div class="space-y-0.5 max-h-40 overflow-y-auto pr-1">
                            @foreach ($availableRoles as $roleKey => $roleLabel)
                                @php $isCurrent = ($currentRole === $roleKey); @endphp
                                <a href="{{ url('/dev/login-as/' . $roleKey) }}"
                                   class="flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition duration-150 {{ $isCurrent ? 'bg-amber-50 text-amber-800 font-semibold ring-1 ring-inset ring-amber-600/20' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                    <span class="truncate">{{ $roleLabel }}</span>
                                    @if ($isCurrent)
                                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('starter') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Starter Template
                        </a>
                        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-rose-600 hover:bg-rose-50 font-medium transition text-left cursor-pointer">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</header>
