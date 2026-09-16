{{-- Modern Floating Toast Notification Container --}}
<div id="toast-container" 
     class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm w-full pointer-events-none px-4 sm:px-0"
     aria-live="polite">

    {{-- 1. Success Toast --}}
    @if (session('success'))
        <div class="toast-item pointer-events-auto flex flex-col bg-white/95 backdrop-blur-md border border-emerald-200/80 rounded-xl shadow-lg shadow-emerald-500/10 overflow-hidden transform transition-all duration-300 ease-out translate-x-12 opacity-0"
             data-auto-dismiss="4000" role="alert">
            <div class="p-3.5 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100/80 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h4 class="text-xs font-semibold text-gray-900 tracking-tight">Berhasil!</h4>
                    <p class="text-xs text-gray-600 mt-0.5 leading-relaxed break-words">{{ session('success') }}</p>
                </div>
                <button type="button" 
                        onclick="dismissToast(this.closest('.toast-item'))" 
                        class="shrink-0 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none"
                        aria-label="Tutup notifikasi">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{-- Progress bar timer --}}
            <div class="h-1 bg-emerald-100 w-full overflow-hidden">
                <div class="toast-progress-bar h-full bg-emerald-500 transition-all ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif

    {{-- 2. Error Toast --}}
    @if (session('error'))
        <div class="toast-item pointer-events-auto flex flex-col bg-white/95 backdrop-blur-md border border-rose-200/80 rounded-xl shadow-lg shadow-rose-500/10 overflow-hidden transform transition-all duration-300 ease-out translate-x-12 opacity-0"
             data-auto-dismiss="5000" role="alert">
            <div class="p-3.5 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-rose-100/80 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h4 class="text-xs font-semibold text-gray-900 tracking-tight">Terjadi Kesalahan</h4>
                    <p class="text-xs text-gray-600 mt-0.5 leading-relaxed break-words">{{ session('error') }}</p>
                </div>
                <button type="button" 
                        onclick="dismissToast(this.closest('.toast-item'))" 
                        class="shrink-0 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none"
                        aria-label="Tutup notifikasi">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="h-1 bg-rose-100 w-full overflow-hidden">
                <div class="toast-progress-bar h-full bg-rose-500 transition-all ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif

    {{-- 3. Warning Toast --}}
    @if (session('warning'))
        <div class="toast-item pointer-events-auto flex flex-col bg-white/95 backdrop-blur-md border border-amber-200/80 rounded-xl shadow-lg shadow-amber-500/10 overflow-hidden transform transition-all duration-300 ease-out translate-x-12 opacity-0"
             data-auto-dismiss="4500" role="alert">
            <div class="p-3.5 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-100/80 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h4 class="text-xs font-semibold text-gray-900 tracking-tight">Peringatan</h4>
                    <p class="text-xs text-gray-600 mt-0.5 leading-relaxed break-words">{{ session('warning') }}</p>
                </div>
                <button type="button" 
                        onclick="dismissToast(this.closest('.toast-item'))" 
                        class="shrink-0 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none"
                        aria-label="Tutup notifikasi">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="h-1 bg-amber-100 w-full overflow-hidden">
                <div class="toast-progress-bar h-full bg-amber-500 transition-all ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif

    {{-- 4. Validation Errors Toast --}}
    @if ($errors->any())
        <div class="toast-item pointer-events-auto flex flex-col bg-white/95 backdrop-blur-md border border-rose-200/80 rounded-xl shadow-lg shadow-rose-500/10 overflow-hidden transform transition-all duration-300 ease-out translate-x-12 opacity-0"
             data-auto-dismiss="6000" role="alert">
            <div class="p-3.5 flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-rose-100/80 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h4 class="text-xs font-semibold text-gray-900 tracking-tight">Validasi Gagal ({{ $errors->count() }})</h4>
                    <ul class="mt-1 space-y-1 text-xs text-rose-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="break-words">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" 
                        onclick="dismissToast(this.closest('.toast-item'))" 
                        class="shrink-0 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none"
                        aria-label="Tutup notifikasi">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="h-1 bg-rose-100 w-full overflow-hidden">
                <div class="toast-progress-bar h-full bg-rose-500 transition-all ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif
</div>

{{-- Toast Script: Handles Animation, Auto-dismiss, Pause on Hover, and Global API --}}
<script>
    (function () {
        function initToast(toast) {
            if (!toast || toast.dataset.initialized) return;
            toast.dataset.initialized = 'true';

            // Trigger enter animation on next tick
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    toast.classList.remove('translate-x-12', 'opacity-0');
                    toast.classList.add('translate-x-0', 'opacity-100');
                });
            });

            const duration = parseInt(toast.dataset.autoDismiss || 4000, 10);
            if (duration <= 0) return;

            const progressBar = toast.querySelector('.toast-progress-bar');
            let startTime = Date.now();
            let remaining = duration;
            let timerId = null;

            if (progressBar) {
                progressBar.style.transition = `width ${duration}ms linear`;
                requestAnimationFrame(() => {
                    progressBar.style.width = '0%';
                });
            }

            function startTimer() {
                startTime = Date.now();
                timerId = setTimeout(() => {
                    dismissToast(toast);
                }, remaining);
            }

            function pauseTimer() {
                if (!timerId) return;
                clearTimeout(timerId);
                timerId = null;
                const elapsed = Date.now() - startTime;
                remaining = Math.max(0, remaining - elapsed);

                if (progressBar) {
                    const currentWidth = (remaining / duration) * 100;
                    progressBar.style.transition = 'none';
                    progressBar.style.width = `${currentWidth}%`;
                }
            }

            function resumeTimer() {
                if (timerId || remaining <= 0) return;
                if (progressBar) {
                    progressBar.style.transition = `width ${remaining}ms linear`;
                    requestAnimationFrame(() => {
                        progressBar.style.width = '0%';
                    });
                }
                startTimer();
            }

            toast.addEventListener('mouseenter', pauseTimer);
            toast.addEventListener('mouseleave', resumeTimer);

            startTimer();
        }

        window.dismissToast = function (toast) {
            if (!toast || toast.dataset.dismissing) return;
            toast.dataset.dismissing = 'true';

            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-12', 'opacity-0');

            setTimeout(() => {
                toast.remove();
            }, 320);
        };

        window.showToast = function (message, type = 'success', title = null, duration = 4000) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const config = {
                success: {
                    title: title || 'Berhasil!',
                    border: 'border-emerald-200/80',
                    shadow: 'shadow-emerald-500/10',
                    iconBg: 'bg-emerald-100/80 text-emerald-600',
                    barBg: 'bg-emerald-500',
                    barTrack: 'bg-emerald-100',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                },
                error: {
                    title: title || 'Terjadi Kesalahan',
                    border: 'border-rose-200/80',
                    shadow: 'shadow-rose-500/10',
                    iconBg: 'bg-rose-100/80 text-rose-600',
                    barBg: 'bg-rose-500',
                    barTrack: 'bg-rose-100',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />'
                },
                warning: {
                    title: title || 'Peringatan',
                    border: 'border-amber-200/80',
                    shadow: 'shadow-amber-500/10',
                    iconBg: 'bg-amber-100/80 text-amber-600',
                    barBg: 'bg-amber-500',
                    barTrack: 'bg-amber-100',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />'
                }
            };

            const t = config[type] || config.success;
            const toast = document.createElement('div');
            toast.className = `toast-item pointer-events-auto flex flex-col bg-white/95 backdrop-blur-md border ${t.border} rounded-xl shadow-lg ${t.shadow} overflow-hidden transform transition-all duration-300 ease-out translate-x-12 opacity-0`;
            toast.dataset.autoDismiss = duration;
            toast.setAttribute('role', 'alert');

            toast.innerHTML = `
                <div class="p-3.5 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg ${t.iconBg} flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            ${t.icon}
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <h4 class="text-xs font-semibold text-gray-900 tracking-tight">${t.title}</h4>
                        <p class="text-xs text-gray-600 mt-0.5 leading-relaxed break-words">${message}</p>
                    </div>
                    <button type="button" 
                            onclick="dismissToast(this.closest('.toast-item'))" 
                            class="shrink-0 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none"
                            aria-label="Tutup notifikasi">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="h-1 ${t.barTrack} w-full overflow-hidden">
                    <div class="toast-progress-bar h-full ${t.barBg} transition-all ease-linear" style="width: 100%;"></div>
                </div>
            `;

            container.appendChild(toast);
            initToast(toast);
        };

        // Initialize server-rendered toasts on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#toast-container .toast-item').forEach(initToast);
        });

        // Also run immediately if script executes after DOM is already loaded
        if (document.readyState !== 'loading') {
            document.querySelectorAll('#toast-container .toast-item').forEach(initToast);
        }
    })();
</script>
