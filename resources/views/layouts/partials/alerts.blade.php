{{-- Flash Messages & Validation Alerts --}}
<div class="space-y-2 mb-5">
    {{-- Success --}}
    @if (session('success'))
        <div id="alert-success" class="flex items-center justify-between px-3.5 py-2.5 bg-emerald-50/80 border border-emerald-200 text-emerald-900 rounded text-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.closest('#alert-success').remove()" class="text-emerald-500 hover:text-emerald-800 ml-3">
                &times;
            </button>
        </div>
    @endif

    {{-- Error --}}
    @if (session('error'))
        <div id="alert-error" class="flex items-center justify-between px-3.5 py-2.5 bg-rose-50/80 border border-rose-200 text-rose-900 rounded text-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.closest('#alert-error').remove()" class="text-rose-500 hover:text-rose-800 ml-3">
                &times;
            </button>
        </div>
    @endif

    {{-- Warning --}}
    @if (session('warning'))
        <div id="alert-warning" class="flex items-center justify-between px-3.5 py-2.5 bg-amber-50/80 border border-amber-200 text-amber-900 rounded text-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span class="font-medium">{{ session('warning') }}</span>
            </div>
            <button type="button" onclick="this.closest('#alert-warning').remove()" class="text-amber-500 hover:text-amber-800 ml-3">
                &times;
            </button>
        </div>
    @endif

    {{-- Form Validation Errors --}}
    @if ($errors->any())
        <div id="alert-validation" class="p-3 bg-rose-50/80 border border-rose-200 text-rose-900 rounded text-xs">
            <div class="flex items-center justify-between font-semibold mb-1">
                <span>Terjadi kesalahan validasi:</span>
                <button type="button" onclick="this.closest('#alert-validation').remove()" class="text-rose-500 hover:text-rose-800">&times;</button>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-rose-700 pl-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
