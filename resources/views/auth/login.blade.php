@extends('layouts.app')

@section('title', 'Masuk Multi-Role – SomeFood')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Masuk ke SomeFood</h1>
            <p class="text-xs text-slate-500 mt-1">Autentikasi Multi-Role (Admin, Kitchen Staff, Pelanggan) & Google/JWT Login</p>
        </div>

        <!-- Google OAuth Quick Login Buttons -->
        <div class="space-y-2 mb-6">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center">One-Click Google OAuth / Role Demo</p>
            <div class="grid grid-cols-1 gap-2">
                <a href="{{ route('auth.google', ['email' => 'admin@somefood.com', 'name' => 'Novan Admin', 'role' => 'admin']) }}"
                   class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-bold text-slate-800 transition">
                    <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                    Login Google sebagai Admin (Dashboard & CRUD)
                </a>
                <a href="{{ route('auth.google', ['email' => 'kitchen@somefood.com', 'name' => 'Chef Budi', 'role' => 'kitchen_staff']) }}"
                   class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-bold text-slate-800 transition">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Login Google sebagai Kitchen Staff (KDS)
                </a>
                <a href="{{ route('auth.google', ['email' => 'customer@somefood.com', 'name' => 'Rina Pelanggan', 'role' => 'customer']) }}"
                   class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-bold text-slate-800 transition">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Login Google sebagai Customer (Pelanggan)
                </a>
            </div>
        </div>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
            <div class="relative flex justify-center text-xs"><span class="bg-white px-2 text-slate-400">atau gunakan email & password</span></div>
        </div>

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', 'admin@somefood.com') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" value="password" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-500">
                <p class="text-[11px] text-slate-400 mt-1">Default demo password: <code>password</code></p>
            </div>

            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-sm">
                Masuk Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
