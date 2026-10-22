<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BI Kantin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-amber-500/20">
                        BI
                    </div>
                    <div>
                        <span class="text-lg font-bold text-gray-900 block leading-tight">BI Kantin</span>
                        <span class="text-xs text-amber-600 font-semibold tracking-wider uppercase">Portal Admin</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-gray-900">{{ session('username') }}</span>
                        <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-amber-100 text-amber-800 rounded-full">Administrator</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl text-sm transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl flex items-center justify-between text-emerald-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl text-red-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') ?? 'Terdapat kesalahan pada input Anda.' }}</span>
                </div>
                @if($errors->any())
                    <ul class="list-disc list-inside mt-2 text-xs text-red-700 ml-8">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Menu</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalMenu }}</p>
                    <span class="text-xs text-gray-400">Item terdaftar</span>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ $pesananMenunggu }}</p>
                    <span class="text-xs text-gray-400">Perlu diproses</span>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $pesananProses }}</p>
                    <span class="text-xs text-gray-400">Dimasak / Siap</span>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pendapatan Selesai</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <span class="text-xs text-gray-400">Pesanan tuntas</span>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Section Monitoring Pesanan Masuk -->
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>Monitoring Pesanan Masuk</span>
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan perbarui status pesanan dari siswa secara langsung</p>
                </div>
                <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl flex items-center gap-1.5 self-start sm:self-auto transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Segarkan Data
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">No. Order</th>
                            <th class="px-6 py-4">Pemesan</th>
                            <th class="px-6 py-4">Menu & Porsi</th>
                            <th class="px-6 py-4">Total Biaya</th>
                            <th class="px-6 py-4">Status Terkini</th>
                            <th class="px-6 py-4 text-center">Kelola Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pesanans as $pesanan)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-mono font-bold text-gray-900">#{{ $pesanan->id }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900">{{ $pesanan->user->username ?? 'User #' . $pesanan->user_id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $pesanan->menu->nama_menu ?? 'Menu Telah Dihapus' }}</div>
                                    <div class="text-xs text-gray-500">{{ $pesanan->jumlah }} porsi @ Rp {{ number_format($pesanan->menu->harga ?? 0, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match($pesanan->status) {
                                            'Menunggu Konfirmasi' => 'bg-amber-100 text-amber-800 border-amber-300',
                                            'Sedang Dimasak' => 'bg-blue-100 text-blue-800 border-blue-300',
                                            'Siap Diambil' => 'bg-purple-100 text-purple-800 border-purple-300',
                                            'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                            'Dibatalkan' => 'bg-red-100 text-red-800 border-red-300',
                                            default => 'bg-gray-100 text-gray-800 border-gray-300'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClass }}">
                                        {{ $pesanan->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.pesanan.status', $pesanan->id) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" 
                                            class="text-xs font-medium rounded-lg border-gray-300 border px-3 py-1.5 bg-white text-gray-700 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-200 outline-none transition">
                                            <option value="Menunggu Konfirmasi" {{ $pesanan->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="Sedang Dimasak" {{ $pesanan->status == 'Sedang Dimasak' ? 'selected' : '' }}>Sedang Dimasak</option>
                                            <option value="Siap Diambil" {{ $pesanan->status == 'Siap Diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                            <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Dibatalkan" {{ $pesanan->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="font-medium text-gray-500">Belum ada pesanan yang masuk saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section CRUD Menu Kantin -->
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Manajemen Menu Kantin</h2>
                    <p class="text-sm text-gray-500 mt-1">Tambah, perbarui, atau hapus daftar menu makanan & minuman</p>
                </div>
                <button onclick="openAddMenuModal()" 
                    class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl text-sm shadow-lg shadow-amber-500/20 flex items-center gap-2 transition self-start sm:self-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Menu Baru
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50/80 text-xs uppercase font-semibold text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Nama Menu</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Harga Satuan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($menus as $menu)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-mono font-semibold text-gray-500">#{{ $menu->id }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $menu->nama_menu }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $menu->kategori == 'Makanan' ? 'bg-orange-100 text-orange-800' : 'bg-cyan-100 text-cyan-800' }}">
                                        {{ $menu->kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button onclick="openEditMenuModal({{ $menu->id }}, '{{ addslashes($menu->nama_menu) }}', {{ $menu->harga }}, '{{ addslashes($menu->kategori) }}')" 
                                            class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition">
                                            Edit
                                        </button>

                                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu {{ $menu->nama_menu }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada menu yang didaftarkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Tambah Menu -->
    <div id="addMenuModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Tambah Menu Baru</h3>
                <button onclick="closeAddMenuModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>
            <form action="{{ route('admin.menu.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nama Menu</label>
                    <input type="text" name="nama_menu" required placeholder="Contoh: Nasi Goreng Telur" 
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" required min="0" placeholder="Contoh: 12000" 
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Kategori</label>
                    <select name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none bg-white">
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Snack / Cemilan">Snack / Cemilan</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" onclick="closeAddMenuModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Menu -->
    <div id="editMenuModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Perbarui Data Menu</h3>
                <button onclick="closeEditMenuModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>
            <form id="editMenuForm" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Nama Menu</label>
                    <input type="text" id="editNamaMenu" name="nama_menu" required 
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Harga (Rp)</label>
                    <input type="number" id="editHarga" name="harga" required min="0" 
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">Kategori</label>
                    <select id="editKategori" name="kategori" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none bg-white">
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                        <option value="Snack / Cemilan">Snack / Cemilan</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" onclick="closeEditMenuModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition">Update Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts untuk Modal Admin -->
    <script>
        function openAddMenuModal() {
            document.getElementById('addMenuModal').classList.remove('hidden');
        }
        function closeAddMenuModal() {
            document.getElementById('addMenuModal').classList.add('hidden');
        }

        function openEditMenuModal(id, nama, harga, kategori) {
            const form = document.getElementById('editMenuForm');
            form.action = `/admin/menu/${id}`;
            document.getElementById('editNamaMenu').value = nama;
            document.getElementById('editHarga').value = harga;
            document.getElementById('editKategori').value = kategori;
            document.getElementById('editMenuModal').classList.remove('hidden');
        }
        function closeEditMenuModal() {
            document.getElementById('editMenuModal').classList.add('hidden');
        }
    </script>
</body>
</html>
