@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan – SomeFood')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Daftar Akun Pelanggan</h1>
            <p class="text-xs text-slate-500 mt-1">Buat akun untuk memesan menu lebih cepat dan menerima notifikasi pesanan</p>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="62812..."
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-500">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-brand-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 rounded-xl text-sm transition shadow-sm">
                Daftar Akun
            </button>
        </form>
    </div>
</div>
@endsection
