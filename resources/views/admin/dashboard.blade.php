@extends('layouts.app')

@section('title', 'Admin Dashboard – SomeFood')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Dashboard Admin & Statistik Penjualan</h1>
            <p class="text-xs text-slate-500 mt-1">Ringkasan pendapatan real-time, menu terlaris, dan peringatan stok bahan baku makanan.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.menus.index') }}" class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition">
                + Kelola Menu (CRUD)
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                Kelola Kategori
            </a>
            <a href="{{ route('admin.ingredients.index') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                Stok Bahan Makanan
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase text-slate-400">Total Pendapatan (Lunas)</span>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <span class="inline-block mt-2 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">
                {{ $paidOrdersCount }} Transaksi Terbayar
            </span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase text-slate-400">Total Pesanan Masuk</span>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $totalOrders }} Pesanan</p>
            <span class="inline-block mt-2 text-[11px] font-semibold text-brand-700 bg-brand-50 px-2 py-0.5 rounded-md">
                Midtrans & Xendit Terintegrasi
            </span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase text-slate-400">Menu & Kategori Aktif</span>
            <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $activeMenusCount }} Menu</p>
            <span class="inline-block mt-2 text-[11px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md">
                Dalam {{ $categoriesCount }} Kategori Makanan
            </span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold uppercase text-slate-400">Peringatan Stok Bahan</span>
            <p class="text-2xl font-extrabold {{ $lowStockIngredients->count() > 0 ? 'text-red-600' : 'text-emerald-600' }} mt-2">
                {{ $lowStockIngredients->count() }} Bahan Menipis
            </p>
            <a href="{{ route('admin.ingredients.index') }}" class="inline-block mt-2 text-[11px] font-semibold text-red-700 bg-red-50 px-2 py-0.5 rounded-md hover:underline">
                Lihat Manajemen Stok →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-base font-extrabold text-slate-900">Transaksi & Pesanan Terbaru</h2>
                <a href="{{ route('kitchen.index') }}" class="text-xs font-bold text-brand-600 hover:underline">Buka Kitchen Display →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100">
                            <th class="py-3 px-4 font-bold">No. Order</th>
                            <th class="py-3 px-4 font-bold">Pelanggan</th>
                            <th class="py-3 px-4 font-bold">Gateway</th>
                            <th class="py-3 px-4 font-bold">Total</th>
                            <th class="py-3 px-4 font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50/80">
                                <td class="py-3 px-4 font-bold text-slate-900">
                                    <a href="{{ route('orders.show', $order->order_number) }}" class="text-brand-600 hover:underline">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="py-3 px-4">
                                    <p class="font-semibold text-slate-800">{{ $order->customer_name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $order->table_number ?? $order->order_type }}</p>
                                </td>
                                <td class="py-3 px-4 uppercase font-semibold">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $order->payment_gateway }} · {{ $order->payment_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-900">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alert & Top Menus -->
        <div class="space-y-6">
            <!-- Low Stock Ingredients -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-extrabold text-slate-900">Stok Bahan Baku Kritis</h2>
                    <a href="{{ route('admin.ingredients.index') }}" class="text-xs font-bold text-brand-600">Kelola</a>
                </div>
                @if($lowStockIngredients->isEmpty())
                    <p class="text-xs text-slate-500">Semua stok bahan makanan dalam batas aman.</p>
                @else
                    <div class="space-y-2.5">
                        @foreach($lowStockIngredients as $ing)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-red-50/70 border border-red-100 text-xs">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $ing->name }}</p>
                                    <p class="text-[11px] text-slate-500">Min: {{ $ing->min_stock_alert }} {{ $ing->unit }} · Supplier: {{ $ing->supplier }}</p>
                                </div>
                                <span class="font-extrabold text-red-600 bg-white px-2.5 py-1 rounded-lg border border-red-200">
                                    Sisa {{ $ing->stock_quantity }} {{ $ing->unit }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Top Selling Menus -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h2 class="text-sm font-extrabold text-slate-900 mb-3">Menu Terlaris</h2>
                <div class="space-y-3">
                    @forelse($topSellingMenus as $top)
                        <div class="flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-slate-800">{{ $top->menu->name ?? 'Menu' }}</p>
                                <p class="text-[11px] text-slate-400">{{ $top->total_qty }} porsi terjual</p>
                            </div>
                            <span class="font-bold text-brand-600">Rp {{ number_format($top->total_sales, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">Belum ada data penjualan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
