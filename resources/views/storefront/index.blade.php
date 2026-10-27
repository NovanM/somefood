@extends('layouts.app')

@section('title', 'SomeFood – Digital Restaurant Menu & Ordering')

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-brand-500/20 text-brand-100 border border-brand-500/30 mb-4">
                    ✨ Digital Restaurant Platform · Laravel 10
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                    Nikmati Hidangan Terbaik dengan Pemesanan Digital Cepat
                </h1>
                <p class="mt-3 text-slate-300 text-sm sm:text-base">
                    Cari menu favorit, filter berdasarkan kategori makanan, dan bayar instan menggunakan Midtrans atau Xendit disertai notifikasi otomatis ke WhatsApp & Email.
                </p>
            </div>

            <!-- Search Form -->
            <div class="w-full md:w-96">
                <form action="{{ route('home') }}" method="GET" class="bg-white/10 backdrop-blur p-3 rounded-2xl border border-white/15">
                    @if($categorySlug)
                        <input type="hidden" name="category" value="{{ $categorySlug }}">
                    @endif
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Cari Menu atau Kata Kunci</label>
                    <div class="flex gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cth: Wagyu, Salmon, Truffle, Kopi..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-white text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500"
                        >
                        <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition shrink-0">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Filter Pills -->
        <div class="mt-8 flex items-center gap-2 overflow-x-auto pb-2">
            <a href="{{ route('home', array_filter(['search' => $search])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition shrink-0 {{ $categorySlug === '' ? 'bg-brand-600 text-white shadow-sm' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('home', array_filter(['category' => $cat->slug, 'search' => $search])) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold transition shrink-0 flex items-center gap-2 {{ $categorySlug === $cat->slug ? 'bg-brand-600 text-white shadow-sm' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">
                    <span>{{ $cat->name }}</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full bg-black/20">{{ $cat->menus_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Main Storefront Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Menu Grid (2 Columns on Desktop) -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">
                        Daftar Menu Tersedia
                        @if($search)
                            <span class="text-sm font-medium text-slate-500">— Hasil pencarian "{{ $search }}"</span>
                        @endif
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Menampilkan {{ $menus->count() }} hidangan siap saji</p>
                </div>
                @if($search || $categorySlug)
                    <a href="{{ route('home') }}" class="text-xs font-semibold text-brand-600 hover:underline">Reset Filter</a>
                @endif
            </div>

            @if($menus->isEmpty())
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <p class="text-base font-bold text-slate-700">Menu tidak ditemukan</p>
                    <p class="text-xs text-slate-500 mt-1">Coba kata kunci atau kategori makanan lainnya.</p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 px-4 py-2 bg-brand-600 text-white text-xs font-bold rounded-xl">Lihat Semua Menu</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach($menus as $menu)
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                            <div class="relative h-44 bg-slate-100">
                                <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur text-white text-[11px] font-semibold px-2.5 py-1 rounded-lg">
                                    {{ $menu->category->name ?? 'Menu' }}
                                </span>
                                @if($menu->is_featured)
                                    <span class="absolute top-3 right-3 bg-amber-500 text-white text-[11px] font-bold px-2.5 py-1 rounded-lg shadow">
                                        ★ Favorit
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between gap-2">
                                        <h3 class="font-bold text-slate-900 text-base leading-snug">{{ $menu->name }}</h3>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">{{ $menu->description }}</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-xs text-slate-400 block">Harga Porsi</span>
                                        <span class="text-base font-extrabold text-brand-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                    </div>
                                    <button
                                        type="button"
                                        onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ (float) $menu->price }})"
                                        class="bg-slate-900 hover:bg-brand-600 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition">
                                        + Tambah Pesanan
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Order / Checkout Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-24">
                <h3 class="text-lg font-extrabold text-slate-900 flex items-center justify-between">
                    <span>Keranjang Pesanan</span>
                    <span id="cart-badge" class="text-xs bg-brand-100 text-brand-700 px-2.5 py-0.5 rounded-full font-bold">0 item</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Integrasi pembayaran otomatis Midtrans / Xendit & Notifikasi WA/Email.</p>

                <form action="{{ route('orders.store') }}" method="POST" id="checkout-form" class="mt-5 space-y-4">
                    @csrf

                    <!-- Dynamic Cart Items Container -->
                    <div id="cart-items" class="space-y-2 max-h-60 overflow-y-auto border-y border-slate-100 py-3">
                        <p id="empty-cart-msg" class="text-xs text-slate-400 text-center py-4">
                            Belum ada menu dipilih. Klik <strong>+ Tambah Pesanan</strong> pada kartu menu.
                        </p>
                    </div>

                    <div class="flex items-center justify-between text-sm font-bold text-slate-900 pt-1">
                        <span>Estimasi Subtotal</span>
                        <span id="cart-subtotal" class="text-brand-600">Rp 0</span>
                    </div>

                    <div class="space-y-3 pt-2 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pelanggan *</label>
                            <input type="text" name="customer_name" required value="{{ auth()->user()->name ?? '' }}" placeholder="Nama lengkap Anda"
                                   class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp *</label>
                                <input type="text" name="customer_phone" required value="{{ auth()->user()->phone ?? '6281234567890' }}" placeholder="62812..."
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Notifikasi</label>
                                <input type="email" name="customer_email" value="{{ auth()->user()->email ?? '' }}" placeholder="nama@email.com"
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tipe Pesanan</label>
                                <select name="order_type" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-white">
                                    <option value="dine_in">Makan di Tempat (Dine In)</option>
                                    <option value="takeaway">Bawa Pulang (Takeaway)</option>
                                    <option value="delivery">Delivery</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Meja</label>
                                <input type="text" name="table_number" placeholder="Cth: Meja 05" value="Meja 05"
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Metode Pembayaran (API Gateway)</label>
                            <select name="payment_gateway" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-white font-semibold">
                                <option value="midtrans">Midtrans Snap (QRIS / Virtual Account)</option>
                                <option value="xendit">Xendit Invoice (E-Wallet / Retail)</option>
                                <option value="cash">Kasir Tunai (Cash)</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" id="submit-order-btn" disabled
                            class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-slate-300 text-white font-bold py-3 rounded-xl text-xs transition shadow-sm">
                        Buat Pesanan & Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    const cart = {};

    function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function addToCart(id, name, price) {
        if (!cart[id]) {
            cart[id] = { id, name, price, quantity: 1 };
        } else {
            cart[id].quantity += 1;
        }
        renderCart();
    }

    function updateQty(id, delta) {
        if (!cart[id]) return;
        cart[id].quantity += delta;
        if (cart[id].quantity <= 0) {
            delete cart[id];
        }
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cart-items');
        const badge = document.getElementById('cart-badge');
        const subtotalEl = document.getElementById('cart-subtotal');
        const submitBtn = document.getElementById('submit-order-btn');

        const keys = Object.keys(cart);
        if (keys.length === 0) {
            container.innerHTML = `<p class="text-xs text-slate-400 text-center py-4">Belum ada menu dipilih. Klik <strong>+ Tambah Pesanan</strong> pada kartu menu.</p>`;
            badge.textContent = '0 item';
            subtotalEl.textContent = 'Rp 0';
            submitBtn.disabled = true;
            return;
        }

        let html = '';
        let totalQty = 0;
        let subtotal = 0;

        keys.forEach((key, idx) => {
            const item = cart[key];
            totalQty += item.quantity;
            subtotal += item.price * item.quantity;

            html += `
                <div class="flex items-center justify-between gap-2 bg-slate-50 px-3 py-2 rounded-xl">
                    <input type="hidden" name="items[${idx}][menu_id]" value="${item.id}">
                    <input type="hidden" name="items[${idx}][quantity]" value="${item.quantity}">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-800 truncate">${item.name}</p>
                        <p class="text-[11px] text-slate-500">${formatRupiah(item.price)} x ${item.quantity}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-xs font-bold">-</button>
                        <span class="text-xs font-bold px-1.5">${item.quantity}</span>
                        <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-xs font-bold">+</button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        badge.textContent = `${totalQty} item`;
        subtotalEl.textContent = formatRupiah(subtotal);
        submitBtn.disabled = false;
    }
</script>
@endsection
