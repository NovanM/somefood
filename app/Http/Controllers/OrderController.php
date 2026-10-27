<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Services\NotificationService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected NotificationService $notificationService
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'table_number' => ['nullable', 'string', 'max:20'],
            'order_type' => ['required', 'in:dine_in,takeaway,delivery'],
            'payment_gateway' => ['required', 'in:midtrans,xendit,cash'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_id' => ['required', 'exists:menus,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        return DB::transaction(function () use ($validated) {
            $subtotal = 0;
            $itemsPayload = [];

            foreach ($validated['items'] as $itemData) {
                $menu = Menu::findOrFail($itemData['menu_id']);
                $lineTotal = $menu->price * $itemData['quantity'];
                $subtotal += $lineTotal;

                $itemsPayload[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $menu->price,
                    'subtotal' => $lineTotal,
                ];
            }

            $tax = round($subtotal * 0.11, 2); // 11% PB1 / PPN
            $totalAmount = $subtotal + $tax;

            $orderNumber = 'SF-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_phone' => $validated['customer_phone'],
                'table_number' => $validated['table_number'] ?? null,
                'order_type' => $validated['order_type'],
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total_amount' => $totalAmount,
                'payment_gateway' => $validated['payment_gateway'],
                'payment_status' => 'unpaid',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($itemsPayload as $item) {
                $order->items()->create($item);
            }

            $paymentResult = $this->paymentService->createTransaction($order);

            $order->update([
                'payment_reference' => $paymentResult['reference'],
                'payment_url' => $paymentResult['payment_url'],
            ]);

            $this->notificationService->sendOrderNotification($order, 'created');

            return redirect()->route('orders.show', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
        });
    }

    public function show(string $orderNumber)
    {
        $order = Order::with('items.menu.category')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('storefront.order-detail', compact('order'));
    }

    /**
     * Simulate or process webhook payment confirmation (Midtrans / Xendit)
     */
    public function confirmPayment(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $order->update([
            'payment_status' => 'paid',
            'status' => $order->status === 'pending' ? 'preparing' : $order->status,
        ]);

        $this->notificationService->sendOrderNotification($order, 'paid');

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Payment confirmed and WhatsApp/Email notifications dispatched.',
                'order' => $order,
            ]);
        }

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Pembayaran berhasil dikonfirmasi via ' . strtoupper($order->payment_gateway) . '! Notifikasi WhatsApp & Email telah dikirim.');
    }

    /**
     * Kitchen Staff & Admin Order Queue Display (KDS - Kitchen Display System)
     */
    public function kitchenIndex()
    {
        $orders = Order::with('items.menu')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->orderByRaw("CASE status WHEN 'pending' THEN 1 WHEN 'preparing' THEN 2 WHEN 'ready' THEN 3 ELSE 4 END")
            ->latest()
            ->get();

        $completedToday = Order::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->count();

        return view('kitchen.index', compact('orders', 'completedToday'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,preparing,ready,completed,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);
        $this->notificationService->sendOrderNotification($order, 'status_updated');

        return back()->with('success', "Status pesanan #{$order->order_number} diperbarui menjadi " . strtoupper($order->status) . ".");
    }
}
