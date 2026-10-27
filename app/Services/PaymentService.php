<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Create payment transaction via Midtrans or Xendit
     */
    public function createTransaction(Order $order): array
    {
        if ($order->payment_gateway === 'xendit') {
            return $this->createXenditInvoice($order);
        }

        if ($order->payment_gateway === 'midtrans') {
            return $this->createMidtransSnap($order);
        }

        // Cash payment
        return [
            'reference' => 'CASH-' . $order->order_number,
            'payment_url' => route('orders.show', $order->order_number),
            'gateway' => 'cash',
        ];
    }

    /**
     * Midtrans Snap Integration
     */
    protected function createMidtransSnap(Order $order): array
    {
        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production', false);
        $baseUrl = $isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $payload = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email ?? 'guest@somefood.local',
                'phone' => $order->customer_phone ?? '081234567890',
            ],
        ];

        if ($serverKey) {
            try {
                $response = Http::withBasicAuth($serverKey, '')
                    ->post($baseUrl, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'reference' => $data['token'] ?? ('MT-' . $order->order_number),
                        'payment_url' => $data['redirect_url'] ?? route('orders.show', $order->order_number),
                        'gateway' => 'midtrans',
                    ];
                }
            } catch (\Exception $e) {
                Log::warning('Midtrans API call fallback: ' . $e->getMessage());
            }
        }

        // Sandbox simulation fallback when API keys are not configured
        return [
            'reference' => 'MT-SNAP-' . strtoupper(substr(md5($order->order_number), 0, 10)),
            'payment_url' => route('orders.show', ['orderNumber' => $order->order_number, 'simulate_pay' => 'midtrans']),
            'gateway' => 'midtrans',
        ];
    }

    /**
     * Xendit Invoice Integration
     */
    protected function createXenditInvoice(Order $order): array
    {
        $secretKey = config('services.xendit.secret_key');

        $payload = [
            'external_id' => $order->order_number,
            'amount' => (int) $order->total_amount,
            'payer_email' => $order->customer_email ?? 'guest@somefood.local',
            'description' => 'Payment for Order #' . $order->order_number . ' at SomeFood',
        ];

        if ($secretKey) {
            try {
                $response = Http::withBasicAuth($secretKey, '')
                    ->post('https://api.xendit.co/v2/invoices', $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'reference' => $data['id'] ?? ('XN-' . $order->order_number),
                        'payment_url' => $data['invoice_url'] ?? route('orders.show', $order->order_number),
                        'gateway' => 'xendit',
                    ];
                }
            } catch (\Exception $e) {
                Log::warning('Xendit API call fallback: ' . $e->getMessage());
            }
        }

        // Sandbox simulation fallback when API keys are not configured
        return [
            'reference' => 'XN-INV-' . strtoupper(substr(md5($order->order_number), 0, 10)),
            'payment_url' => route('orders.show', ['orderNumber' => $order->order_number, 'simulate_pay' => 'xendit']),
            'gateway' => 'xendit',
        ];
    }
}
