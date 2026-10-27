@extends('layouts.app')

@section('title', 'SomeFood – Lets Go for More Food')

@section('content')

<!-- Full-Width Hero Carousel (Exact Match to Screenshot Slide 1) -->
<div class="relative w-full h-[520px] sm:h-[560px] overflow-hidden bg-slate-900 select-none">

    <!-- Slide 1: Exact Bar Chalkboard Photo from Screenshot -->
    <div class="hero-slide absolute inset-0 transition-opacity duration-700 opacity-100" data-slide="0">
        <img src="{{ asset('images/hero-bar.jpg') }}"
             alt="SomeFood Bar & Restaurant"
             class="w-full h-full object-cover object-[center_52%]">
        <div class="absolute inset-0 bg-black/25"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-white text-3xl sm:text-4xl font-bold tracking-wide drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                SomeFood Lets Go for More Food
            </h1>
            <p class="text-white text-2xl sm:text-3xl font-normal mt-8 drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                All Food for you
            </p>
            <a href="#food-section"
               class="mt-8 inline-block px-6 py-2.5 rounded-md border border-white/90 text-white text-sm font-medium bg-black/20 hover:bg-white hover:text-slate-900 transition shadow">
                Show More
            </a>
        </div>
    </div>

    <!-- Slide 2: Culinary Showcase Slide -->
    <div class="hero-slide absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-slide="1">
        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1600&q=80"
             alt="SomeFood Signature Dishes"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h2 class="text-white text-3xl sm:text-4xl font-bold tracking-wide drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                SomeFood Lets Go for More Food
            </h2>
            <p class="text-white text-2xl sm:text-3xl font-normal mt-8 drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                Fresh Ingredients & Authentic Taste
            </p>
            <a href="#food-section"
               class="mt-8 inline-block px-6 py-2.5 rounded-md border border-white/90 text-white text-sm font-medium bg-black/20 hover:bg-white hover:text-slate-900 transition shadow">
                Show More
            </a>
        </div>
    </div>

    <!-- Slide 3: Fine Dining & Beverage Slide -->
    <div class="hero-slide absolute inset-0 transition-opacity duration-700 opacity-0 pointer-events-none" data-slide="2">
        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1600&q=80"
             alt="SomeFood Dining Experience"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h2 class="text-white text-3xl sm:text-4xl font-bold tracking-wide drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                SomeFood Lets Go for More Food
            </h2>
            <p class="text-white text-2xl sm:text-3xl font-normal mt-8 drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                Order Online with Instant Payment
            </p>
            <a href="#food-section"
               class="mt-8 inline-block px-6 py-2.5 rounded-md border border-white/90 text-white text-sm font-medium bg-black/20 hover:bg-white hover:text-slate-900 transition shadow">
                Show More
            </a>
        </div>
    </div>

    <!-- Carousel Prev / Next Controls -->
    <button type="button" onclick="changeSlide(-1)" aria-label="Previous slide"
            class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center transition">
        &#10094;
    </button>
    <button type="button" onclick="changeSlide(1)" aria-label="Next slide"
            class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center transition">
        &#10095;
    </button>

    <!-- Carousel Indicators -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2">
        <button type="button" onclick="goToSlide(0)" class="carousel-dot w-2.5 h-2.5 rounded-full bg-white transition"></button>
        <button type="button" onclick="goToSlide(1)" class="carousel-dot w-2.5 h-2.5 rounded-full bg-white/40 transition"></button>
        <button type="button" onclick="goToSlide(2)" class="carousel-dot w-2.5 h-2.5 rounded-full bg-white/40 transition"></button>
    </div>
</div>

<!-- Food By Category Section Header (Exact Match to Screenshot) -->
<section id="food-section" class="pt-12 pb-6 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl font-normal text-slate-800 tracking-wide">
            Food By Category
        </h2>
        <p class="text-sm text-slate-500 mt-3">
            SomeFood This is Food in this Menu for you want
        </p>

        <!-- Search & Category Filter Bar -->
        <div class="mt-8 max-w-2xl mx-auto">
            <form action="{{ route('home') }}#food-section" method="GET" class="flex flex-col sm:flex-row gap-2">
                @if($categorySlug)
                    <input type="hidden" name="category" value="{{ $categorySlug }}">
                @endif
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search menu or keyword (e.g. Wagyu, Salmon, Pasta, Coffee)..."
                    class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:border-[#2b4c7e]"
                >
                <button type="submit" class="bg-[#2b4c7e] hover:bg-[#233f6b] text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition">
                    Search
                </button>
                @if($search || $categorySlug)
                    <a href="{{ route('home') }}#food-section" class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 text-sm font-medium hover:bg-slate-50">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Category Cards / Pills -->
        <div class="mt-7 flex items-center justify-center gap-2.5 flex-wrap">
            <a href="{{ route('home', array_filter(['search' => $search])) }}#food-section"
               class="px-4 py-2 rounded-full text-xs font-semibold transition {{ $categorySlug === '' ? 'bg-[#2b4c7e] text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All Categories
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('home', array_filter(['category' => $cat->slug, 'search' => $search])) }}#food-section"
                   class="px-4 py-2 rounded-full text-xs font-semibold transition flex items-center gap-1.5 {{ $categorySlug === $cat->slug ? 'bg-[#2b4c7e] text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    <span>{{ $cat->name }}</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $categorySlug === $cat->slug ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $cat->menus_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Main Menu Grid & Order Sidebar -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Menu Grid -->
        <div class="lg:col-span-2">
            @if($menus->isEmpty())
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-12 text-center">
                    <p class="text-base font-bold text-slate-700">Menu tidak ditemukan</p>
                    <p class="text-xs text-slate-500 mt-1">Coba kata kunci atau kategori makanan lainnya.</p>
                    <a href="{{ route('home') }}#food-section" class="inline-block mt-4 px-4 py-2 bg-[#2b4c7e] text-white text-xs font-bold rounded-lg">Show All Food</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($menus as $menu)
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                            <div class="relative h-48 bg-slate-100">
                                <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                <span class="absolute top-3 left-3 bg-[#2b4c7e]/90 backdrop-blur text-white text-[11px] font-semibold px-2.5 py-1 rounded">
                                    {{ $menu->category->name ?? 'Menu' }}
                                </span>
                                @if($menu->is_featured)
                                    <span class="absolute top-3 right-3 bg-amber-500 text-white text-[11px] font-bold px-2.5 py-1 rounded shadow">
                                        ★ Popular
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base">{{ $menu->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">{{ $menu->description }}</p>
                                </div>
                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[11px] text-slate-400 block">Price</span>
                                        <span class="text-base font-bold text-[#2b4c7e]">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                    </div>
                                    <button
                                        type="button"
                                        onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ (float) $menu->price }})"
                                        class="bg-[#2b4c7e] hover:bg-[#233f6b] text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                        + Add Order
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
            <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm sticky top-24">
                <h3 class="text-base font-bold text-slate-900 flex items-center justify-between">
                    <span>Order Summary</span>
                    <span id="cart-badge" class="text-xs bg-blue-50 text-[#2b4c7e] px-2.5 py-0.5 rounded-full font-bold">0 item</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Midtrans / Xendit Payment & WhatsApp/Email Notification.</p>

                <form action="{{ route('orders.store') }}" method="POST" id="checkout-form" class="mt-4 space-y-4">
                    @csrf

                    <div id="cart-items" class="space-y-2 max-h-56 overflow-y-auto border-y border-slate-100 py-3">
                        <p id="empty-cart-msg" class="text-xs text-slate-400 text-center py-4">
                            Belum ada menu dipilih. Klik <strong>+ Add Order</strong> pada kartu menu.
                        </p>
                    </div>

                    <div class="flex items-center justify-between text-sm font-bold text-slate-900 pt-1">
                        <span>Subtotal</span>
                        <span id="cart-subtotal" class="text-[#2b4c7e]">Rp 0</span>
                    </div>

                    <div class="space-y-3 pt-2 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Customer Name *</label>
                            <input type="text" name="customer_name" required value="{{ auth()->user()->name ?? '' }}" placeholder="Your full name"
                                   class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-[#2b4c7e]">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">WhatsApp *</label>
                                <input type="text" name="customer_phone" required value="{{ auth()->user()->phone ?? '6281234567890' }}" placeholder="62812..."
                                       class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-[#2b4c7e]">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                                <input type="email" name="customer_email" value="{{ auth()->user()->email ?? '' }}" placeholder="name@email.com"
                                       class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-[#2b4c7e]">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Order Type</label>
                                <select name="order_type" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-white">
                                    <option value="dine_in">Dine In</option>
                                    <option value="takeaway">Takeaway</option>
                                    <option value="delivery">Delivery</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Table No.</label>
                                <input type="text" name="table_number" placeholder="Table 05" value="Table 05"
                                       class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-[#2b4c7e]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Payment Gateway</label>
                            <select name="payment_gateway" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-white font-semibold">
                                <option value="midtrans">Midtrans (QRIS / VA)</option>
                                <option value="xendit">Xendit (Invoice / E-Wallet)</option>
                                <option value="cash">Cashier (Cash)</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" id="submit-order-btn" disabled
                            class="w-full bg-[#2b4c7e] hover:bg-[#233f6b] disabled:bg-slate-300 text-white font-bold py-2.5 rounded-lg text-xs transition shadow-sm">
                        Checkout & Pay Now
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

<script>
    // Hero Carousel Logic
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.carousel-dot');

    function goToSlide(index) {
        currentSlide = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
            if (i === currentSlide) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('opacity-100');
            } else {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0', 'pointer-events-none');
            }
        });
        dots.forEach((dot, i) => {
            dot.className = i === currentSlide
                ? 'carousel-dot w-2.5 h-2.5 rounded-full bg-white transition'
                : 'carousel-dot w-2.5 h-2.5 rounded-full bg-white/40 transition';
        });
    }

    function changeSlide(step) {
        goToSlide(currentSlide + step);
    }

    // Shopping Cart Logic
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
            container.innerHTML = `<p class="text-xs text-slate-400 text-center py-4">Belum ada menu dipilih. Klik <strong>+ Add Order</strong> pada kartu menu.</p>`;
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
                <div class="flex items-center justify-between gap-2 bg-slate-50 px-3 py-2 rounded-lg">
                    <input type="hidden" name="items[${idx}][menu_id]" value="${item.id}">
                    <input type="hidden" name="items[${idx}][quantity]" value="${item.quantity}">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-800 truncate">${item.name}</p>
                        <p class="text-[11px] text-slate-500">${formatRupiah(item.price)} x ${item.quantity}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded bg-white border border-slate-200 text-xs font-bold">-</button>
                        <span class="text-xs font-bold px-1.5">${item.quantity}</span>
                        <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded bg-white border border-slate-200 text-xs font-bold">+</button>
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
