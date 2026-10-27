<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SomeFood – Laravel Restaurant Management Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-white/95 backdrop-blur border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-amber-600 flex items-center justify-center text-white font-extrabold text-xl shadow-sm">
                        SF
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900">Some<span class="text-brand-600">Food</span></span>
                        <span class="hidden sm:inline-block text-[11px] font-semibold uppercase tracking-wider bg-brand-50 text-brand-700 px-2 py-0.5 rounded-full ml-1">Restaurant OS</span>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-1 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Katalog Menu
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.menus.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.menus.*') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                Kelola Menu
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                Kategori
                            </a>
                            <a href="{{ route('admin.ingredients.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('admin.ingredients.*') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                Stok Bahan
                            </a>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isKitchenStaff())
                            <a href="{{ route('kitchen.index') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('kitchen.*') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                Kitchen Display (KDS)
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-slate-900">{{ auth()->user()->name }}</p>
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full
                                {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-700' : (auth()->user()->role === 'kitchen_staff' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-700') }}">
                                {{ str_replace('_', ' ', auth()->user()->role) }}
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-slate-600 hover:text-red-600 border border-slate-200 hover:border-red-200 px-3 py-2 rounded-lg transition">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-brand-600 px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-xl shadow-sm transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2 text-sm font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div>
                <span class="font-bold text-slate-800">SomeFood</span> — Laravel 10 Restaurant Management Platform (Sanctum, Midtrans/Xendit, WhatsApp & Email Notification)
            </div>
            <div class="flex items-center gap-4">
                <span>Multi-Role: Admin · Kitchen Staff · Customer</span>
            </div>
        </div>
    </footer>

</body>
</html>
