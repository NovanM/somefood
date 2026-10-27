@extends('layouts.app')

@section('title', 'Manajemen Kategori Makanan (CRUD) – SomeFood')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Manajemen Kategori Makanan (CRUD)</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola pengelompokan kategori menu untuk memudahkan pencarian pelanggan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Category -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h2 class="text-base font-extrabold text-slate-900 mb-4">+ Tambah Kategori Baru</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Kategori *</label>
                        <input type="text" name="name" required placeholder="Cth: Paket Keluarga"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">URL Gambar</label>
                        <input type="url" name="image" placeholder="https://images.unsplash.com/..."
                               class="w-full px-3 py-2 rounded-xl border border-slate-200">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Penjelasan singkat kategori..."
                                  class="w-full px-3 py-2 rounded-xl border border-slate-200"></textarea>
                    </div>
                    <label class="inline-flex items-center gap-2 font-semibold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" checked>
                        Kategori Aktif
                    </label>
                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-xl transition">
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Category List -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($categories as $category)
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400">Nama Kategori</label>
                                <input type="text" name="name" value="{{ $category->name }}" required
                                       class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 font-bold text-slate-900">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold uppercase text-slate-400">Deskripsi</label>
                                <input type="text" name="description" value="{{ $category->description }}"
                                       class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <div class="flex items-center gap-4">
                                <span class="text-slate-500 font-semibold">{{ $category->menus_count }} Menu Terdaftar</span>
                                <label class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                                    <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                    Aktif
                                </label>
                            </div>
                            <button type="submit" class="bg-slate-900 hover:bg-brand-600 text-white font-bold px-3.5 py-1.5 rounded-lg transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="mt-2 text-right" onsubmit="return confirm('Hapus kategori beserta menunya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[11px] font-semibold text-red-600 hover:underline">Hapus Kategori</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
