<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Dispatch WhatsApp and Email notifications for an Order event
     */
    public function sendOrderNotification(Order $order, string $event = 'created'): void
    {
        $this->sendWhatsApp($order, $event);
        $this->sendEmail($order, $event);
    }

    /**
     * Send WhatsApp Notification via External Gateway (Fonnte / Twilio / Wablas compatible)
     */
    public function sendWhatsApp(Order $order, string $event = 'created'): bool
    {
        if (! $order->customer_phone) {
            return false;
        }

        $message = $this->buildMessage($order, $event);
        $waToken = config('services.whatsapp.token');
        $waEndpoint = config('services.whatsapp.endpoint', 'https://api.fonnte.com/send');

        if ($waToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $waToken,
                ])->post($waEndpoint, [
                    'target' => $order->customer_phone,
                    'message' => $message,
                ]);

                return $response->successful();
            } catch (\Exception $e) {
                Log::warning('WhatsApp API Error: ' . $e->getMessage());
            }
        }

        Log::info("[WhatsApp Notification Simulated] To: {$order->customer_phone} | Message: {$message}");
        return true;
    }

    /**
     * Send Email Notification
     */
    public function sendEmail(Order $order, string $event = 'created'): bool
    {
        if (! $order->customer_email) {
            return false;
        }

        $message = $this->buildMessage($order, $event);

        try {
            Mail::raw($message, function ($mail) use ($order, $event) {
                $mail->to($order->customer_email)
                    ->subject("SomeFood - Order #{$order->order_number} (" . ucfirst($event) . ")");
            });
            return true;
        } catch (\Exception $e) {
            Log::info("[Email Notification Logged] To: {$order->customer_email} | Event: {$event}");
            return false;
        }
    }

    protected function buildMessage(Order $order, string $event): string
    {
        $total = 'Rp ' . number_format($order->total_amount, 0, ',', '.');

        return match ($event) {
            'paid' => "Halo {$order->customer_name}! Pembayaran pesanan #{$order->order_number} sebesar {$total} telah kami terima. Pesanan Anda sedang disiapkan oleh dapur kami.",
            'status_updated' => "Halo {$order->customer_name}! Status pesanan #{$order->order_number} kini: *" . strtoupper($order->status) . "*. Terima kasih telah memesan di SomeFood!",
            default => "Halo {$order->customer_name}! Terima kasih telah memesan di SomeFood. Nomor Pesanan: #{$order->order_number} | Total: {$total} | Metode: " . strtoupper($order->payment_gateway) . ".",
        };
    }
}
