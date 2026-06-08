<x-app-layout title="Manajemen Siswa">

    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Siswa</h1>
            <p class="text-gray-500 text-sm mt-1" id="jumlah-siswa">{{ $siswas->total() }} siswa terdaftar</p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <button onclick="document.getElementById('import-modal').classList.remove('hidden')"
                class="inline-flex items-center gap-2 text-sm text-brand-600 font-medium bg-brand-50 border border-brand-200 hover:bg-brand-100 px-4 py-2.5 rounded-xl transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Import Excel
            </button>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white/80 backdrop-blur px-4 py-2.5 rounded-xl hover:border-brand-200 transition-all">
                ← Dashboard
            </a>
        </div>
    </div>

    {{-- Filter dan Live Search --}}
    <div class="mb-6 grid gap-3 animate-fade-up" style="animation-delay:.06s">
        <div class="grid gap-3 md:grid-cols-[1.5fr_1fr_auto]">
            <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                <input type="text" id="search-input" placeholder="Cari nama, NIS, email, atau kelas..."
                    class="input-focus w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white/80 backdrop-blur transition-all shadow-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Filter Kelas</label>
                <select id="kelas-filter" class="input-focus w-full px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white">
                    <option value="">Semua kelas</option>
                    @foreach($kelasList as $kls)
                        <option value="{{ $kls }}" {{ request('kelas') === $kls ? 'selected' : '' }}>{{ $kls }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="button" id="reset-filter" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition-all">Reset</button>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.1s">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Siswa</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">NIS</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kelas</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aktif</th>
                    <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel-siswa" class="divide-y divide-gray-50">
                @foreach($siswas as $siswa)
                <tr class="hover:bg-brand-50/30 transition-colors duration-150 group siswa-row" id="row-{{ $siswa->id }}" data-kelas="{{ $siswa->kelas }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $siswa->fotoUrl() }}" alt="{{ $siswa->name }}"
                                class="w-9 h-9 rounded-full object-cover flex-shrink-0 group-hover:scale-110 transition-transform duration-200 shadow-sm border border-gray-100">
                            <div>
                                <a href="{{ route('admin.riwayat.siswa', $siswa) }}" class="text-sm font-medium text-gray-900 hover:text-brand-600 transition-colors">{{ $siswa->name }}</a>
                                <p class="text-xs text-gray-400">{{ $siswa->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="font-mono text-sm text-gray-600">{{ $siswa->nis }}</span></td>
                    <td class="px-6 py-4"><span class="text-sm text-gray-600">{{ $siswa->kelas ?? '-' }}</span></td>
                    <td class="px-6 py-4 text-center"><span class="text-sm font-semibold text-gray-700">{{ $siswa->peminjaman_count }}</span></td>
                    <td class="px-6 py-4 text-center">
                        @if($siswa->peminjaman_aktif > 0)
                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-ping-slow"></span>{{ $siswa->peminjaman_aktif }}
                        </span>
                        @else
                        <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="toggleEdit({{ $siswa->id }})"
                                class="btn-ripple text-xs font-medium text-brand-600 border border-brand-200 hover:bg-brand-50 px-3 py-1.5 rounded-lg transition-all">Edit</button>
                        </div>
                    </td>
                </tr>
                <tr id="edit-{{ $siswa->id }}" class="hidden bg-brand-50/40 border-b border-brand-100">
                    <td colspan="6" class="px-6 py-4">
                        <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="flex items-end gap-3 flex-wrap">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama</label>
                                    <input type="text" name="name" value="{{ $siswa->name }}"
                                        class="input-focus px-3 py-2 rounded-lg border border-gray-200 text-sm w-44">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">NIS</label>
                                    <input type="text" name="nis" value="{{ $siswa->nis }}"
                                        class="input-focus px-3 py-2 rounded-lg border border-gray-200 text-sm font-mono w-36">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $siswa->email }}"
                                        class="input-focus px-3 py-2 rounded-lg border border-gray-200 text-sm w-52">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Kelas</label>
                                    <select name="kelas" class="input-focus px-3 py-2 rounded-lg border border-gray-200 text-sm bg-white">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['X TJKT 1','X TJKT 2','X SIJA 1','X SIJA 2','XI TJKT 1','XI TJKT 2','XI SIJA 1','XI SIJA 2','XII TJKT 1','XII TJKT 2','XII SIJA 1','XII SIJA 2'] as $kls)
                                        <option value="{{ $kls }}" {{ $siswa->kelas===$kls?'selected':'' }}>{{ $kls }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="btn-ripple px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg transition-all shadow-sm">Simpan</button>
                                    <button type="button" onclick="toggleEdit({{ $siswa->id }})"
                                        class="px-4 py-2 border border-gray-200 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition-all">Batal</button>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-slate-50 border-t border-gray-100">
            {{ $siswas->links('vendor.pagination.custom') }}
        </div>
        <div id="empty-state" class="hidden text-center py-16">
            <p class="text-gray-400 text-sm">Tidak ada siswa yang cocok</p>
        </div>
    </div>

    <script>
    function toggleEdit(id) {
        const row = document.getElementById('edit-' + id);
        const isHidden = row.classList.contains('hidden');
        row.classList.toggle('hidden');
        if (isHidden) {
            row.style.animation = 'fade-up .3s cubic-bezier(.22,1,.36,1) both';
        }
    }

    const searchInput = document.getElementById('search-input');
    const kelasFilter = document.getElementById('kelas-filter');
    const resetFilter = document.getElementById('reset-filter');
    const tabelSiswa = document.getElementById('tabel-siswa');
    const jumlahSiswa = document.getElementById('jumlah-siswa');
    const emptyState = document.getElementById('empty-state');
    const paginationDiv = document.querySelector('.bg-slate-50');
    let searchTimeout;

    // Build URL with parameters
    function buildURL(cari, kelas) {
        const params = new URLSearchParams();
        if (cari) params.append('cari', cari);
        if (kelas) params.append('kelas', kelas);
        
        return params.toString() 
            ? window.location.pathname + '?' + params.toString()
            : window.location.pathname;
    }

    // Fetch data with live search
    async function performLiveSearch() {
        const cari = searchInput.value.trim();
        const kelas = kelasFilter.value;
        
        try {
            const params = new URLSearchParams();
            if (cari) params.append('cari', cari);
            if (kelas) params.append('kelas', kelas);
            const queryString = params.toString();

            const response = await fetch(`${window.location.pathname}${queryString ? `?${queryString}` : ''}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const result = await response.json();
            updateTable(result.data, result.total);
            updateURL(cari, kelas);
            
            // Hide pagination when searching
            if (cari || kelas) {
                paginationDiv.style.display = 'none';
            } else {
                paginationDiv.style.display = '';
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    // Update table with new data
    function updateTable(data, total) {
        tabelSiswa.innerHTML = '';

        if (data.length === 0) {
            emptyState.classList.remove('hidden');
            jumlahSiswa.textContent = '0 siswa terdaftar';
            return;
        }

        emptyState.classList.add('hidden');
        jumlahSiswa.textContent = total + ' siswa terdaftar';

        data.forEach(siswa => {
            const statusAktif = siswa.peminjaman_aktif > 0 
                ? `<span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-ping-slow"></span>${siswa.peminjaman_aktif}
                  </span>`
                : '<span class="text-xs text-gray-300">—</span>';

            const row = document.createElement('tr');
            row.className = 'hover:bg-brand-50/30 transition-colors duration-150 group siswa-row';
            row.id = 'row-' + siswa.id;
            row.dataset.kelas = siswa.kelas;

            row.innerHTML = `
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="${siswa.fotoUrl}" alt="${siswa.name}"
                            class="w-9 h-9 rounded-full object-cover flex-shrink-0 group-hover:scale-110 transition-transform duration-200 shadow-sm border border-gray-100">
                        <div>
                            <a href="/admin/riwayat/siswa/${siswa.id}" class="text-sm font-medium text-gray-900 hover:text-brand-600 transition-colors">${siswa.name}</a>
                            <p class="text-xs text-gray-400">${siswa.email}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4"><span class="font-mono text-sm text-gray-600">${siswa.nis}</span></td>
                <td class="px-6 py-4"><span class="text-sm text-gray-600">${siswa.kelas}</span></td>
                <td class="px-6 py-4 text-center"><span class="text-sm font-semibold text-gray-700">${siswa.peminjaman_count}</span></td>
                <td class="px-6 py-4 text-center">${statusAktif}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button onclick="toggleEdit(${siswa.id})"
                            class="btn-ripple text-xs font-medium text-brand-600 border border-brand-200 hover:bg-brand-50 px-3 py-1.5 rounded-lg transition-all">Edit</button>
                    </div>
                </td>
            `;

            tabelSiswa.appendChild(row);
        });
    }

    // Update URL without reloading
    function updateURL(cari, kelas) {
        const url = buildURL(cari, kelas);
        window.history.replaceState({}, document.title, url);
    }

    // Event listeners untuk live search
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performLiveSearch, 300);
    });

    // Kelas filter - instant update
    kelasFilter.addEventListener('change', performLiveSearch);

    // Reset filter button
    resetFilter.addEventListener('click', function() {
        searchInput.value = '';
        kelasFilter.value = '';
        performLiveSearch();
    });

    // Set initial values from URL
    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        const cari = params.get('cari');
        const kelas = params.get('kelas');

        if (cari) searchInput.value = cari;
        if (kelas) kelasFilter.value = kelas;
    });
    </script>

    {{-- Import Modal --}}
    <div id="import-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Import Siswa dari Excel</h2>
                <p class="text-sm text-gray-500 mt-1">Upload file Excel berisi data siswa baru</p>
            </div>
            
            <form id="import-form" action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-brand-400 transition-colors" onclick="document.getElementById('excel-file').click()">
                        <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4m0 0V8m0 4h4m-4 0H8"/>
                        </svg>
                        <p class="text-sm text-gray-600" id="file-name">Klik atau drag file ke sini</p>
                        <p class="text-xs text-gray-500 mt-1">Format: .xlsx, .xls (Max 5MB)</p>
                        <input type="file" id="excel-file" name="file" accept=".xlsx,.xls" class="hidden">
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-xs text-gray-600 mb-2">Format kolom Excel:</p>
                    <ul class="text-xs text-gray-500 space-y-1">
                        <li>• Kolom A: Nama</li>
                        <li>• Kolom B: NIS</li>
                        <li>• Kolom C: Email</li>
                        <li>• Kolom D: Kelas (opsional)</li>
                    </ul>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg transition-all font-medium">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // File upload handler
    document.getElementById('excel-file').addEventListener('change', function() {
        const fileName = this.files[0]?.name || 'File dipilih';
        document.getElementById('file-name').textContent = fileName;
    });

    // Drag and drop
    const dropZone = document.querySelector('[onclick="document.getElementById(\'excel-file\').click()"]');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('border-brand-400', 'bg-brand-50');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('border-brand-400', 'bg-brand-50');
        });
    });

    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        document.getElementById('excel-file').files = files;
        document.getElementById('file-name').textContent = files[0]?.name || 'File dipilih';
    });

    // Handle form submission
    document.getElementById('import-form').addEventListener('submit', function(e) {
        const fileInput = document.getElementById('excel-file');
        if (!fileInput.files.length) {
            e.preventDefault();
            alert('Silakan pilih file Excel terlebih dahulu');
        }
    });
    </script>

</x-app-layout>
