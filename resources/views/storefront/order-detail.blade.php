@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' – SomeFood')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-slate-900 text-white p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Nomor Pesanan Digital</span>
                <h1 class="text-2xl font-extrabold text-white mt-0.5">#{{ $order->order_number }}</h1>
                <p class="text-xs text-slate-300 mt-1">{{ $order->created_at->format('d M Y, H:i') }} · {{ strtoupper(str_replace('_', ' ', $order->order_type)) }} {{ $order->table_number ? '('.$order->table_number.')' : '' }}</p>
            </div>
            <div class="flex flex-col sm:items-end gap-1.5">
                <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase
                    {{ $order->payment_status === 'paid' ? 'bg-emerald-500 text-white' : 'bg-amber-400 text-slate-900' }}">
                    Pembayaran: {{ strtoupper($order->payment_status) }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-white/10 text-slate-200">
                    Status Dapur: {{ strtoupper($order->status) }}
                </span>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Customer & Payment Metadata -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs">
                <div>
                    <p class="text-slate-400 font-semibold uppercase">Informasi Pelanggan</p>
                    <p class="font-bold text-slate-800 text-sm mt-1">{{ $order->customer_name }}</p>
                    <p class="text-slate-600">WhatsApp: {{ $order->customer_phone ?? '-' }}</p>
                    <p class="text-slate-600">Email: {{ $order->customer_email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-400 font-semibold uppercase">Integrasi Payment Gateway</p>
                    <p class="font-bold text-slate-800 text-sm mt-1 uppercase">{{ $order->payment_gateway }}</p>
                    <p class="text-slate-600">Ref ID: <code class="bg-white px-1.5 py-0.5 rounded border">{{ $order->payment_reference }}</code></p>
                    <p class="text-emerald-700 font-medium mt-1">✓ Notifikasi WA & Email Aktif</p>
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h2 class="text-sm font-extrabold text-slate-900 mb-3">Rincian Menu Dipesan</h2>
                <div class="divide-y divide-slate-100 border border-slate-200 rounded-xl overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-3.5 flex items-center justify-between text-xs bg-white">
                            <div>
                                <p class="font-bold text-slate-900 text-sm">{{ $item->menu->name ?? 'Menu' }}</p>
                                <p class="text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                            </div>
                            <span class="font-bold text-slate-900 text-sm">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals -->
            <div class="space-y-1.5 text-sm border-t border-slate-200 pt-4">
                <div class="flex justify-between text-xs text-slate-500">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs text-slate-500">
                    <span>Pajak Restoran (PB1 11%)</span>
                    <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-base font-extrabold text-slate-900 pt-2">
                    <span>Total Pembayaran</span>
                    <span class="text-brand-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Action -->
            @if($order->payment_status !== 'paid')
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-amber-900">
                        <p class="font-bold text-sm">Menunggu Konfirmasi Pembayaran ({{ strtoupper($order->payment_gateway) }})</p>
                        <p class="mt-0.5">Klik tombol di samping untuk mensimulasikan callback pelunasan API {{ strtoupper($order->payment_gateway) }} dan mengirim notifikasi WhatsApp/Email.</p>
                    </div>
                    <form action="{{ route('orders.pay', $order->order_number) }}" method="POST" class="shrink-0">
                        @csrf
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-sm transition">
                            Konfirmasi Bayar ({{ strtoupper($order->payment_gateway) }})
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-xs text-emerald-900 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-sm">✓ Pembayaran Lunas</p>
                        <p>Pesanan Anda sedang diproses oleh Kitchen Staff dan bukti pembayaran telah dikirim ke WhatsApp & Email Anda.</p>
                    </div>
                    <a href="{{ route('home') }}" class="bg-white border border-emerald-300 text-emerald-800 font-bold px-4 py-2 rounded-xl">Pesan Lagi</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
