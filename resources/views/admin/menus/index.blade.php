@extends('layouts.app')

@section('title', 'Manajemen Menu (CRUD) – SomeFood')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Manajemen Menu Makanan (CRUD)</h1>
            <p class="text-xs text-slate-500 mt-1">Tambah, ubah, dan hapus menu lengkap dengan gambar, deskripsi, kategori, dan harga.</p>
        </div>

        <!-- Search & Filter Bar -->
        <form action="{{ route('admin.menus.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama menu..."
                   class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
            <select name="category_id" class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-slate-900 text-white text-xs font-bold px-4 py-2 rounded-xl">Filter</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Create Menu Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-24">
                <h2 class="text-base font-extrabold text-slate-900 mb-4">+ Tambah Menu Baru</h2>
                <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Hidangan *</label>
                        <input type="text" name="name" required placeholder="Cth: Bebek Betutu Bali"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori *</label>
                        <select name="category_id" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Harga (Rp) *</label>
                            <input type="number" name="price" required min="0" placeholder="55000"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Estimasi Masak (Menit)</label>
                            <input type="number" name="preparation_time" value="15" min="1"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">URL Gambar Menu</label>
                        <input type="url" name="image" placeholder="https://images.unsplash.com/..."
                               class="w-full px-3 py-2 rounded-xl border border-slate-200">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Lengkap</label>
                        <textarea name="description" rows="3" placeholder="Komposisi bahan dan cita rasa..."
                                  class="w-full px-3 py-2 rounded-xl border border-slate-200"></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-1">
                        <label class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                            <input type="checkbox" name="is_available" value="1" checked class="rounded text-brand-600">
                            Tersedia
                        </label>
                        <label class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                            <input type="checkbox" name="is_featured" value="1" class="rounded text-brand-600">
                            Menu Favorit
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-xl transition">
                        Simpan Menu
                    </button>
                </form>
            </div>
        </div>

        <!-- Menu List & Inline Edit/Delete -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($menus as $menu)
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                    <form action="{{ route('admin.menus.update', $menu) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col sm:flex-row gap-4">
                            <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full sm:w-28 h-28 rounded-xl object-cover bg-slate-100 shrink-0">
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                                <div class="sm:col-span-2">
                                    <label class="block text-[10px] font-bold uppercase text-slate-400">Nama Menu</label>
                                    <input type="text" name="name" value="{{ $menu->name }}" required
                                           class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 font-bold text-slate-900">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-slate-400">Kategori</label>
                                    <select name="category_id" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $menu->category_id === $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase text-slate-400">Harga (Rp)</label>
                                    <input type="number" name="price" value="{{ (int) $menu->price }}" required
                                           class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 font-bold text-brand-600">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[10px] font-bold uppercase text-slate-400">URL Gambar</label>
                                    <input type="url" name="image" value="{{ $menu->image }}"
                                           class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-[10px] font-bold uppercase text-slate-400">Deskripsi</label>
                                    <input type="text" name="description" value="{{ $menu->description }}"
                                           class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                                    <input type="checkbox" name="is_available" value="1" {{ $menu->is_available ? 'checked' : '' }}>
                                    Tersedia
                                </label>
                                <label class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                                    <input type="checkbox" name="is_featured" value="1" {{ $menu->is_featured ? 'checked' : '' }}>
                                    Favorit
                                </label>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="submit" class="bg-slate-900 hover:bg-brand-600 text-white font-bold px-3.5 py-1.5 rounded-lg transition">
                                    Update Menu
                                </button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="mt-2 text-right" onsubmit="return confirm('Hapus menu ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[11px] font-semibold text-red-600 hover:underline">Hapus Menu</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
