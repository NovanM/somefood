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
                        navy: {
                            600: '#2b4c7e',
                            700: '#233f6b',
                            800: '#1b3254',
                        },
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#2b4c7e',
                            600: '#233f6b',
                            700: '#1b3254',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;1,700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-800 min-h-screen flex flex-col">

    <!-- Navbar (Exact match to SomeFood screenshot: #2b4c7e navy header) -->
    <header class="bg-[#2b4c7e] text-white sticky top-0 z-40 shadow-md">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-xl font-bold italic tracking-wide text-white hover:opacity-90 transition">
                    SomeFood
                </a>

                @auth
                    <div class="hidden md:flex items-center gap-2 text-xs font-semibold border-l border-white/20 pl-6">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-1.5 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.menus.index') }}" class="px-2.5 py-1.5 rounded {{ request()->routeIs('admin.menus.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                                CRUD Menu
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="px-2.5 py-1.5 rounded {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                                Kategori
                            </a>
                            <a href="{{ route('admin.ingredients.index') }}" class="px-2.5 py-1.5 rounded {{ request()->routeIs('admin.ingredients.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                                Stok Bahan
                            </a>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isKitchenStaff())
                            <a href="{{ route('kitchen.index') }}" class="px-2.5 py-1.5 rounded {{ request()->routeIs('kitchen.*') ? 'bg-white/20 text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                                Kitchen (KDS)
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <nav class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-white hover:text-slate-200 transition">Home</a>
                <a href="{{ route('home') }}#food-section" class="text-white hover:text-slate-200 transition">Food</a>
                <a href="{{ route('home') }}#news-section" class="text-white hover:text-slate-200 transition">News</a>
                <a href="{{ route('home') }}#about-section" class="text-white hover:text-slate-200 transition">About Me</a>

                @auth
                    <div class="flex items-center gap-2 pl-3 border-l border-white/20">
                        <span class="hidden sm:inline-block text-xs bg-white/15 px-2.5 py-1 rounded text-white font-semibold">
                            {{ auth()->user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs bg-red-500/80 hover:bg-red-600 text-white px-2.5 py-1 rounded transition">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs bg-white/15 hover:bg-white/25 text-white px-3 py-1.5 rounded border border-white/30 transition">
                        Login
                    </a>
                @endauth
            </nav>
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
    <footer id="about-section" class="bg-[#2b4c7e] text-white mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/80">
            <div>
                <span class="font-bold italic text-white text-sm">SomeFood</span> — Laravel 10 Restaurant Management Platform
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="#food-section" class="hover:text-white">Food</a>
                <a href="{{ route('login') }}" class="hover:text-white">Admin & Staff Portal</a>
            </div>
        </div>
    </footer>

</body>
</html>
