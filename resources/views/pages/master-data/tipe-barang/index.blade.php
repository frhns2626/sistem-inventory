@extends('layouts.app')

@section('title', 'Tipe Barang')
@section('page-title', 'Tipe Barang')
@section('page-group', 'Master Data')

@section('content')

    {{-- HEADER MODUL --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div>
            <h1 class="text-base font-bold text-zinc-900 tracking-tight flex items-center gap-2">
                <span>Master Tipe Barang</span>
                <span class="text-[10px] font-mono font-medium px-2 py-0.5 rounded bg-zinc-100 border border-zinc-200 text-zinc-600">
                    Sifat Logistik
                </span>
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">Kelola tipe dan sifat perlakuan barang (habis pakai, aset, bahan baku, dll).</p>
        </div>

        <div class="flex items-center gap-2 text-xs">

            <button type="button" onclick="openCreateModal()" class="px-3.5 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white font-medium rounded transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>+ Tipe Baru</span>
            </button>
        </div>
    </div>

    {{-- KANVAS TABEL --}}
    <div class="bg-white border border-zinc-200 rounded shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-zinc-50 border-b border-zinc-200 text-[11px] font-semibold text-zinc-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 w-12 text-center">#</th>
                        <th class="px-4 py-3 w-32">Kode Tipe</th>
                        <th class="px-4 py-3">Nama Tipe</th>
                        <th class="px-4 py-3">Deskripsi Perlakuan</th>
                        <th class="px-4 py-3 w-28 text-center">Jumlah Item</th>
                        <th class="px-4 py-3 w-24 text-center">Status</th>
                        <th class="px-4 py-3 w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($itemTypes as $index => $type)
                        <tr class="hover:bg-zinc-50/60 transition">
                            <td class="px-4 py-3 text-center font-mono text-zinc-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <span class="font-mono font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded border border-zinc-200 text-[11px]">
                                    {{ $type->code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-zinc-900">
                                {{ $type->name }}
                            </td>
                            <td class="px-4 py-3 text-zinc-500 max-w-sm truncate">
                                {{ $type->description ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center font-mono font-semibold text-zinc-800">
                                {{ $type->items_count }} item
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($type->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-zinc-100 text-zinc-500 border border-zinc-200">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- Edit Button --}}
                                    <button type="button"
                                            onclick='openEditModal(@json($type))'
                                            class="p-1 text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 rounded transition cursor-pointer" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    {{-- Delete Button (Hanya jika belum dipakai) --}}
                                    @if ($type->items_count == 0)
                                        <form action="{{ route('item-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tipe barang ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-zinc-400 hover:text-rose-600 hover:bg-rose-50 rounded transition cursor-pointer" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-zinc-400 font-mono">
                                Belum ada data tipe barang. Silakan tambahkan tipe baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT TIPE BARANG --}}
    <div id="type-modal" class="fixed inset-0 bg-zinc-950/50 z-50 hidden backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-lg border border-zinc-200 shadow-xl max-w-md w-full overflow-hidden">

            <form id="type-form" method="POST" action="{{ route('item-types.store') }}">
                @csrf
                <div id="method-container"></div>

                <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
                    <h3 id="modal-title" class="text-sm font-bold text-zinc-900">Tambah Tipe Barang</h3>
                    <button type="button" onclick="closeModal()" class="text-zinc-400 hover:text-zinc-700 text-lg leading-none cursor-pointer">&times;</button>
                </div>

                <div class="p-5 space-y-3.5 text-xs">
                    <div>
                        <label class="block font-medium text-zinc-700 mb-1">Kode Tipe (Singkat)</label>
                        <input type="text" name="code" id="modal-code" placeholder="Contoh: PRD, AST, CSM" required
                               class="w-full uppercase font-mono bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block font-medium text-zinc-700 mb-1">Nama Tipe Barang</label>
                        <input type="text" name="name" id="modal-name" placeholder="Contoh: Barang Jadi (Finished Goods)" required
                               class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block font-medium text-zinc-700 mb-1">Deskripsi / Catatan Perlakuan</label>
                        <textarea name="description" id="modal-description" rows="2" placeholder="Jelaskan alur atau perlakuan barang tipe ini..."
                                  class="w-full bg-zinc-50 border border-zinc-200 rounded px-3 py-1.5 focus:bg-white focus:border-zinc-400 focus:outline-none transition"></textarea>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="is_active" id="modal-active" value="1" checked class="rounded border-zinc-300 text-zinc-900 focus:ring-0">
                        <label for="modal-active" class="text-zinc-700 font-medium">Aktifkan tipe ini untuk katalog barang</label>
                    </div>
                </div>

                <div class="px-5 py-3.5 bg-zinc-50 border-t border-zinc-100 flex items-center justify-end gap-2 text-xs">
                    <button type="button" onclick="closeModal()" class="px-3 py-1.5 bg-white border border-zinc-200 hover:bg-zinc-100 text-zinc-700 rounded transition font-medium cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-1.5 bg-zinc-900 hover:bg-zinc-800 text-white rounded transition font-medium cursor-pointer">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('type-modal');
        const form = document.getElementById('type-form');
        const modalTitle = document.getElementById('modal-title');
        const codeInput = document.getElementById('modal-code');
        const nameInput = document.getElementById('modal-name');
        const descInput = document.getElementById('modal-description');
        const activeInput = document.getElementById('modal-active');
        const methodContainer = document.getElementById('method-container');

        function openCreateModal() {
            modalTitle.innerText = 'Tambah Tipe Barang Baru';
            form.action = "{{ route('item-types.store') }}";
            methodContainer.innerHTML = '';
            codeInput.value = '';
            nameInput.value = '';
            descInput.value = '';
            activeInput.checked = true;
            modal.classList.remove('hidden');
        }

        function openEditModal(type) {
            modalTitle.innerText = 'Edit Tipe Barang: ' + type.name;
            form.action = "{{ url('/item-types') }}/" + type.id;
            methodContainer.innerHTML = '@method("PUT")';
            codeInput.value = type.code;
            nameInput.value = type.name;
            descInput.value = type.description || '';
            activeInput.checked = type.is_active ? true : false;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        // Tutup modal jika klik di luar box
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });
        }
    </script>

@endsection
