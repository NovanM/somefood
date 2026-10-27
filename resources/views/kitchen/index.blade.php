@extends('layouts.app')

@section('title', 'Kitchen Display System (KDS) – SomeFood')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-wider text-amber-600">Role: Kitchen Staff & Admin</span>
            <h1 class="text-2xl font-extrabold text-slate-900">Kitchen Display System (Antrean Dapur)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui status masakan secara langsung; pelanggan otomatis menerima notifikasi WhatsApp & Email.</p>
        </div>
        <div class="bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700">
            Pesanan Selesai Hari Ini: <span class="text-emerald-600 font-extrabold">{{ $completedToday }}</span>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <p class="text-base font-bold text-slate-700">Tidak ada antrean pesanan aktif saat ini</p>
            <p class="text-xs text-slate-400 mt-1">Semua pesanan dapur telah diselesaikan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border-2 {{ $order->status === 'ready' ? 'border-emerald-400' : ($order->status === 'preparing' ? 'border-amber-400' : 'border-slate-200') }} shadow-sm p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-2 pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-sm font-extrabold text-slate-900">#{{ $order->order_number }}</span>
                                <p class="text-xs font-semibold text-slate-600">{{ $order->customer_name }} · {{ $order->table_number ?? strtoupper($order->order_type) }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase
                                {{ $order->status === 'ready' ? 'bg-emerald-100 text-emerald-800' : ($order->status === 'preparing' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                                {{ $order->status }}
                            </span>
                        </div>

                        <ul class="py-3 space-y-2 text-xs divide-y divide-slate-100">
                            @foreach($order->items as $item)
                                <li class="pt-2 first:pt-0 flex items-center justify-between">
                                    <span class="font-bold text-slate-800">{{ $item->quantity }}x {{ $item->menu->name ?? 'Menu' }}</span>
                                    <span class="text-slate-400">{{ $item->menu->preparation_time ?? 15 }} mnt</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <form action="{{ route('kitchen.orders.status', $order) }}" method="POST" class="pt-3 border-t border-slate-100 flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="flex-1 px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold bg-slate-50">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing (Dimasak)</option>
                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready (Siap Saji)</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        </select>
                        <button type="submit" class="bg-slate-900 hover:bg-brand-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                            Update
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
