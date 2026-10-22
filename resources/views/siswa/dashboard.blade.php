<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog & Pesanan - BI Kantin</title>
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
                    <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-orange-500/20">
                        BI
                    </div>
                    <div>
                        <span class="text-lg font-bold text-gray-900 block leading-tight">BI Kantin</span>
                        <span class="text-xs text-orange-600 font-semibold tracking-wider uppercase">Portal Siswa</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-gray-900">{{ session('username') }}</span>
                        <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-orange-100 text-orange-800 rounded-full">Siswa</span>
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
                    <span class="text-sm font-medium">{{ session('error') ?? 'Terjadi kesalahan pada pemesanan.' }}</span>
                </div>
            </div>
        @endif

        <!-- Banner Siap Diambil Alert (Dynamic Real-time) -->
        <div id="readyPickupBanner" class="hidden bg-purple-600 text-white p-4 rounded-2xl shadow-lg shadow-purple-500/20 flex items-center justify-between animate-pulse">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-base">Makanan Siap Diambil!</h4>
                    <p class="text-xs text-purple-100" id="readyPickupText">Pesanan Anda telah siap, silakan segera ambil di loket kantin.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri: Katalog Makanan (2 Kolom) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Katalog Makanan & Minuman</h2>
                            <p class="text-sm text-gray-500 mt-1">Pilih menu favorit Anda dan pesan dengan mudah</p>
                        </div>
                        <!-- Kategori Filter -->
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0" id="categoryFilters">
                            <button onclick="filterCategory('all')" class="cat-btn active px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-orange-500 text-white transition">Semua</button>
                            @foreach($kategoriList as $kategori)
                                <button onclick="filterCategory('{{ $kategori }}')" class="cat-btn px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">{{ $kategori }}</button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Grid Item Menu -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        @forelse($menus as $menu)
                            <div class="menu-card bg-gray-50/60 hover:bg-white rounded-2xl p-5 border border-gray-200/80 hover:border-orange-300 hover:shadow-md transition duration-200 flex flex-col justify-between" data-category="{{ $menu->kategori }}">
                                <div>
                                    <div class="flex items-start justify-between gap-2 mb-2">
                                        <h3 class="font-bold text-gray-900 text-base leading-snug">{{ $menu->nama_menu }}</h3>
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $menu->kategori == 'Makanan' ? 'bg-orange-100 text-orange-800' : 'bg-cyan-100 text-cyan-800' }}">
                                            {{ $menu->kategori }}
                                        </span>
                                    </div>
                                    <div class="text-orange-600 font-extrabold text-lg mb-4">
                                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Form Pemesanan Per Menu -->
                                <form action="{{ route('siswa.pesan') }}" method="POST" class="pt-3 border-t border-gray-200/60 flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <div class="w-20">
                                        <input type="number" name="jumlah" value="1" min="1" max="50" required 
                                            class="w-full px-2.5 py-2 text-center text-sm font-semibold rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none bg-white">
                                    </div>
                                    <button type="submit" 
                                        class="flex-1 py-2 px-3 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] text-white font-semibold text-xs rounded-xl shadow-md shadow-orange-500/20 transition flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Pesan Sekarang
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="col-span-2 py-12 text-center text-gray-400">
                                Menu saat ini belum tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Status & Riwayat Pesanan Real-time (1 Kolom) -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span>Status Pesanan Saya</span>
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                </span>
                            </h2>
                            <span class="text-xs text-gray-500">Pembaruan real-time otomatis</span>
                        </div>
                        <button onclick="fetchRealtimeOrders()" class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition" title="Refresh manual">
                            <svg id="refreshIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>

                    <!-- Container List Pesanan -->
                    <div id="ordersContainer" class="divide-y divide-gray-100 mt-2 max-h-[600px] overflow-y-auto space-y-3">
                        @forelse($pesanans as $order)
                            <div class="order-item pt-3 pb-2" id="order-{{ $order->id }}">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-mono font-bold text-gray-400">Order #{{ $order->id }}</span>
                                    @php
                                        $badgeColor = match($order->status) {
                                            'Menunggu Konfirmasi' => 'bg-amber-100 text-amber-800 border-amber-300',
                                            'Sedang Dimasak' => 'bg-blue-100 text-blue-800 border-blue-300',
                                            'Siap Diambil' => 'bg-purple-100 text-purple-800 border-purple-300 ring-2 ring-purple-300 ring-offset-1 font-bold animate-bounce',
                                            'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                            'Dibatalkan' => 'bg-red-100 text-red-800 border-red-300',
                                            default => 'bg-gray-100 text-gray-800 border-gray-300'
                                        };
                                    @endphp
                                    <span class="order-status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                                        {{ $order->status }}
                                    </span>
                                </div>
                                <div class="font-bold text-gray-900 text-sm">
                                    {{ $order->menu->nama_menu ?? 'Menu Dihapus' }}
                                </div>
                                <div class="flex items-center justify-between text-xs text-gray-500 mt-1">
                                    <span>{{ $order->jumlah }} porsi</span>
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @empty
                            <div id="emptyOrdersMessage" class="py-10 text-center text-gray-400 text-sm">
                                Belum ada pesanan dibuat.<br>
                                <span class="text-xs text-gray-400">Silakan pilih makanan di katalog sebelah kiri.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Script Kategori & Real-time Status Polling -->
    <script>
        // Filter Kategori Katalog
        function filterCategory(cat) {
            const cards = document.querySelectorAll('.menu-card');
            const buttons = document.querySelectorAll('.cat-btn');

            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-orange-500', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            });
            event.target.classList.add('active', 'bg-orange-500', 'text-white');
            event.target.classList.remove('bg-gray-100', 'text-gray-600');

            cards.forEach(card => {
                if (cat === 'all' || card.getAttribute('data-category') === cat) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Real-time Polling Status Pesanan
        function getBadgeClass(status) {
            switch(status) {
                case 'Menunggu Konfirmasi':
                    return 'bg-amber-100 text-amber-800 border-amber-300';
                case 'Sedang Dimasak':
                    return 'bg-blue-100 text-blue-800 border-blue-300';
                case 'Siap Diambil':
                    return 'bg-purple-100 text-purple-800 border-purple-300 ring-2 ring-purple-300 ring-offset-1 font-bold animate-bounce';
                case 'Selesai':
                    return 'bg-emerald-100 text-emerald-800 border-emerald-300';
                case 'Dibatalkan':
                    return 'bg-red-100 text-red-800 border-red-300';
                default:
                    return 'bg-gray-100 text-gray-800 border-gray-300';
            }
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        }

        async function fetchRealtimeOrders() {
            const icon = document.getElementById('refreshIcon');
            if (icon) icon.classList.add('animate-spin');

            try {
                const response = await fetch("{{ route('siswa.status.realtime') }}");
                if (!response.ok) return;

                const orders = await response.json();
                const container = document.getElementById('ordersContainer');
                const banner = document.getElementById('readyPickupBanner');
                const bannerText = document.getElementById('readyPickupText');

                if (orders.length === 0) {
                    container.innerHTML = `
                        <div id="emptyOrdersMessage" class="py-10 text-center text-gray-400 text-sm">
                            Belum ada pesanan dibuat.<br>
                            <span class="text-xs text-gray-400">Silakan pilih makanan di katalog sebelah kiri.</span>
                        </div>
                    `;
                    banner.classList.add('hidden');
                    return;
                }

                let hasReadyPickup = false;
                let readyItemNames = [];

                let html = '';
                orders.forEach(order => {
                    const menuName = order.menu ? order.menu.nama_menu : 'Menu Dihapus';
                    if (order.status === 'Siap Diambil') {
                        hasReadyPickup = true;
                        readyItemNames.push(menuName);
                    }

                    html += `
                        <div class="order-item pt-3 pb-2" id="order-${order.id}">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-mono font-bold text-gray-400">Order #${order.id}</span>
                                <span class="order-status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border ${getBadgeClass(order.status)}">
                                    ${order.status}
                                </span>
                            </div>
                            <div class="font-bold text-gray-900 text-sm">
                                ${menuName}
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-500 mt-1">
                                <span>${order.jumlah} porsi</span>
                                <span class="font-semibold text-gray-900">${formatRupiah(order.total_harga)}</span>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;

                // Tampilkan banner notifikasi jika ada makanan yang Siap Diambil
                if (hasReadyPickup) {
                    banner.classList.remove('hidden');
                    bannerText.textContent = `Pesanan (${readyItemNames.join(', ')}) sudah siap! Silakan ambil di loket sekarang.`;
                } else {
                    banner.classList.add('hidden');
                }

            } catch (err) {
                console.error("Polling error:", err);
            } finally {
                if (icon) icon.classList.remove('animate-spin');
            }
        }

        // Jalankan polling setiap 4 detik untuk update real-time tanpa refresh halaman
        setInterval(fetchRealtimeOrders, 4000);
    </script>
</body>
</html>
