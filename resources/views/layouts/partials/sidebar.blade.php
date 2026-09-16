@php
    // Konfigurasi Navigasi SIMBA
    // Ditata secara modular, authentic Heroicons v2 outline 24x24 (stroke-width="1.5")
    $menuGroups = [
        [
            'group' => '',
            'items' => [
                [
                    'title'       => 'Dashboard',
                    'url'         => url('/'),
                    'route_match' => '/',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>',
                    'permission'  => null,
                ],
            ]
        ],
        [
            'group' => 'Master Data',
            'items' => [
                [
                    'title'       => 'Kategori Barang',
                    'url'         => url('/categories'),
                    'route_match' => 'categories*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v1.75c0 .621.504 1.125 1.125 1.125h7c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125H3.375A1.125 1.125 0 012.25 16.875V7.125z"/></svg>',
                    'permission'  => null,
                ],
                [
                    'title'       => 'Tipe Barang',
                    'url'         => url('/item-types'),
                    'route_match' => 'item-types*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path d="M6 6h.008v.008H6V6z"/></svg>',
                    'permission'  => null,
                ],
                [
                    'title'       => 'Data Barang',
                    'url'         => url('/items'),
                    'route_match' => 'items*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>',
                    'permission'  => 'view items',
                ],
                [
                    'title'       => 'Vendor / Supplier',
                    'url'         => url('/vendors'),
                    'route_match' => 'vendors*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.25V3.75a.75.75 0 00-.75-.75h-9a.75.75 0 00-.75.75v10.5c0 .414.336.75.75.75h9a.75.75 0 00.75-.75z"/></svg>',
                    'permission'  => null,
                ],
            ]
        ],
        [
            'group' => 'Pengadaan',
            'items' => [
                [
                    'title'       => 'Purchase Request (PR)',
                    'url'         => url('/purchase-requests'),
                    'route_match' => 'purchase-requests*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>',
                    'permission'  => null,
                ],
                [
                    'title'       => 'Purchase Order (PO)',
                    'url'         => url('/purchase-orders'),
                    'route_match' => 'purchase-orders*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>',
                    'permission'  => null,
                ],
            ]
        ],
        [
            'group' => 'Gudang & Inventaris',
            'items' => [
                [
                    'title'       => 'Material Requisition (MR)',
                    'url'         => url('/material-requisitions'),
                    'route_match' => 'material-requisitions*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>',
                    'permission'  => 'view material-requisitions',
                ],
                [
                    'title'       => 'Penerimaan (GR)',
                    'url'         => url('/goods-receipts'),
                    'route_match' => 'goods-receipts*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>',
                    'permission'  => 'view goods-receipts',
                ],
                [
                    'title'       => 'Pengeluaran (GI)',
                    'url'         => url('/goods-issues'),
                    'route_match' => 'goods-issues*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>',
                    'permission'  => 'view goods-issues',
                ],
                [
                    'title'       => 'Stok & Mutasi',
                    'url'         => url('/stock'),
                    'route_match' => 'stock*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></svg>',
                    'badge'       => '8 Kritis',
                    'badge_color' => 'rose',
                    'permission'  => 'view stock',
                ],
                [
                    'title'       => 'Stock Opname',
                    'url'         => url('/stock-opnames'),
                    'route_match' => 'stock-opnames*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'permission'  => 'manage stock-opnames',
                ],
            ]
        ],
        [
            'group' => 'Keuangan & Audit',
            'items' => [
                [
                    'title'       => 'Invoices',
                    'url'         => url('/invoices'),
                    'route_match' => 'invoices*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>',
                    'permission'  => 'view invoices',
                ],
                [
                    'title'       => 'Laporan & Audit Log',
                    'url'         => url('/reports'),
                    'route_match' => 'reports*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>',
                    'permission'  => 'view reports',
                ],
            ]
        ],
        [
            'group' => 'Sistem',
            'items' => [
                [
                    'title'       => 'Pengguna & Hak Akses',
                    'url'         => url('/users'),
                    'route_match' => 'users*',
                    'icon'        => '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>',
                    'role'        => 'superadmin',
                    'permission'  => 'manage users',
                ],
            ]
        ],
    ];
@endphp

<aside class="w-64 bg-white border-r border-gray-200 text-gray-700 flex flex-col shrink-0 h-screen sticky top-0 select-none">

    {{-- Header Sidebar: Logo & Identitas Filament-Styled --}}
    <div class="h-16 shrink-0 flex items-center justify-between px-5 border-b border-gray-200 bg-white">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            {{-- Filament Amber Geometric Mark --}}
            <div class="w-8 h-8 rounded-lg bg-amber-500 text-white font-bold flex items-center justify-center text-sm tracking-tight shadow-xs ring-1 ring-amber-600/30 group-hover:bg-amber-600 transition duration-150">
                SB
            </div>
            <div>
                <span class="text-sm font-bold text-gray-950 tracking-tight block leading-tight">SIMBA</span>
                <span class="text-[10px] text-gray-400 font-medium tracking-wide uppercase block">ERP Inventaris</span>
            </div>
        </a>

        {{-- Mobile close button --}}
        <button type="button" id="sidebar-close-btn" 
                class="lg:hidden text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg p-1.5 transition duration-150 cursor-pointer" 
                title="Tutup Menu" 
                aria-label="Close menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Menu Navigasi --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-5 text-xs">
        @foreach ($menuGroups as $group)
            @php
                $visibleItems = collect($group['items'])->filter(function ($item) {
                    if (empty($item['role']) && empty($item['permission'])) return true;
                    if (!auth()->check()) return true;
                    if (!empty($item['role']) && auth()->user()->hasRole($item['role'])) return true;
                    if (!empty($item['permission']) && auth()->user()->can($item['permission'])) return true;
                    return false;
                });
            @endphp

            @if ($visibleItems->isNotEmpty())
                <div>
                    @if (!empty($group['group']))
                        <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-400 font-mono">
                            {{ $group['group'] }}
                        </div>
                    @endif

                    <ul class="space-y-1">
                        @foreach ($visibleItems as $item)
                            @php
                                $isActive = request()->is($item['route_match']);
                            @endphp
                            <li>
                                <a href="{{ $item['url'] }}"
                                   class="relative group flex items-center justify-between px-3 py-2 text-sm rounded-lg transition duration-150 {{ $isActive ? 'bg-amber-50 text-amber-900 font-semibold ring-1 ring-inset ring-amber-600/10 before:absolute before:left-0 before:top-2 before:bottom-2 before:w-1 before:rounded-r-full before:bg-amber-600' : 'text-gray-600 hover:text-gray-950 hover:bg-gray-100/80 font-medium' }}">
                                    
                                    <div class="flex items-center gap-3 truncate">
                                        <span class="{{ $isActive ? 'text-amber-600' : 'text-gray-400 group-hover:text-gray-600' }} transition-colors">
                                            {!! $item['icon'] !!}
                                        </span>
                                        <span class="truncate">{{ $item['title'] }}</span>
                                    </div>

                                    @if (!empty($item['badge']))
                                        @php
                                            $badgeColorClass = ($item['badge_color'] ?? '') === 'rose'
                                                ? 'bg-rose-50 text-rose-700 ring-rose-600/20'
                                                : 'bg-amber-50 text-amber-700 ring-amber-600/20';
                                        @endphp
                                        <span class="rounded-full px-2 py-0.5 text-[11px] font-medium ring-1 ring-inset {{ $badgeColorClass }} shrink-0">
                                            {{ $item['badge'] }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </nav>

    {{-- Footer Bar Sidebar --}}
    <div class="p-3.5 border-t border-gray-200 bg-gray-50/70 text-xs text-gray-500 flex items-center justify-between">
        <span class="inline-flex items-center gap-1.5 font-medium text-gray-700">
            <span class="w-2 h-2 rounded-full bg-emerald-500 ring-2 ring-emerald-500/20"></span>
            <span>Online</span>
        </span>
        <span class="text-[11px] font-mono text-gray-400 font-medium">SIMBA v3.0</span>
    </div>

</aside>

