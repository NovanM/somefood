@extends('layouts.app')

@section('title', 'Manajemen Stok Bahan Makanan – SomeFood')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900">Manajemen Stok Bahan Makanan (Inventory)</h1>
        <p class="text-xs text-slate-500 mt-1">Pantau ketersediaan bahan baku dapur, batas minimum stok, dan harga beli supplier.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Create Ingredient -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h2 class="text-base font-extrabold text-slate-900 mb-4">+ Tambah Bahan Makanan</h2>
                <form action="{{ route('admin.ingredients.store') }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Bahan Baku *</label>
                        <input type="text" name="name" required placeholder="Cth: Keju Parmigiano"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Satuan *</label>
                            <input type="text" name="unit" value="kg" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Stok Saat Ini *</label>
                            <input type="number" step="0.01" name="stock_quantity" required value="10"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Batas Alert Minimum *</label>
                            <input type="number" step="0.01" name="min_stock_alert" required value="5"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Harga per Satuan (Rp) *</label>
                            <input type="number" name="unit_cost" required value="120000"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Supplier</label>
                        <input type="text" name="supplier" placeholder="PT Pangan Nusantara"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200">
                    </div>
                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-xl transition">
                        Tambah Bahan Baku
                    </button>
                </form>
            </div>
        </div>

        <!-- Ingredients Table -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($ingredients as $ing)
                <div class="bg-white rounded-2xl border {{ $ing->isLowStock() ? 'border-red-300 bg-red-50/20' : 'border-slate-200' }} p-4 shadow-sm">
                    <form action="{{ route('admin.ingredients.update', $ing) }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[11px] text-slate-400">{{ $ing->sku }}</span>
                            @if($ing->isLowStock())
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-red-100 text-red-700">
                                    ⚠ STOK MENIPIS
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                    ✓ STOK AMAN
                                </span>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold uppercase text-slate-400">Nama Bahan</label>
                                <input type="text" name="name" value="{{ $ing->name }}" required
                                       class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 font-bold text-slate-900">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400">Stok</label>
                                <input type="number" step="0.01" name="stock_quantity" value="{{ $ing->stock_quantity }}" required
                                       class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 font-bold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400">Min Alert</label>
                                <input type="number" step="0.01" name="min_stock_alert" value="{{ $ing->min_stock_alert }}" required
                                       class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase text-slate-400">Satuan</label>
                                <input type="text" name="unit" value="{{ $ing->unit }}" required
                                       class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200">
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="unit_cost" value="{{ $ing->unit_cost }}">
                                <input type="text" name="supplier" value="{{ $ing->supplier }}" placeholder="Supplier"
                                       class="px-2.5 py-1 rounded-lg border border-slate-200 text-xs">
                                <span class="text-slate-500">Rp {{ number_format($ing->unit_cost, 0, ',', '.') }} / {{ $ing->unit }}</span>
                            </div>
                            <button type="submit" class="bg-slate-900 hover:bg-brand-600 text-white font-bold px-3.5 py-1.5 rounded-lg transition">
                                Update Stok
                            </button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
