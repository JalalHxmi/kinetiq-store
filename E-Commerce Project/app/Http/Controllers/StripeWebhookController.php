<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $secret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            return response('Invalid signature', 400);
        }

        $exists = DB::table('stripe_events')->where('event_id', $event->id)->exists();
        if ($exists) {
            return response('Event already processed', 200);
        }

        DB::table('stripe_events')->insert([
            'event_id' => $event->id,
            'type' => $event->type,
            'payload' => json_encode($event),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $cartId = $session->metadata->cart_id ?? null;
            if ($cartId) {
                DB::transaction(function () use ($cartId, $session) {
                    $cart = Cart::with(['items.product', 'coupon'])->find($cartId);
                    if (!$cart) {
                        return;
                    }

                    $subtotal = 0;
                    foreach ($cart->items as $item) {
                        $subtotal += $item->product->price * $item->quantity;
                    }
                    $discount = 0;
                    if ($cart->coupon) {
                        $discount = $cart->coupon->type === 'percent'
                            ? $subtotal * ($cart->coupon->value / 100)
                            : $cart->coupon->value;
                    }
                    $total = max(0, $subtotal - $discount);

                    $order = Order::create([
                        'user_id' => $cart->user_id,
                        'email' => $session->customer_details->email ?? 'guest@unknown.local',
                        'status' => 'paid',
                        'payment_method' => 'stripe',
                        'coupon_id' => $cart->coupon_id,
                        'subtotal' => $subtotal,
                        'discount' => $discount,
                        'total' => $total,
                        'stripe_session_id' => $session->id,
                        'stripe_payment_intent' => $session->payment_intent,
                        'paid_at' => now(),
                    ]);

                    foreach ($cart->items as $item) {
                        $order->items()->create([
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->product->price,
                        ]);
                        $item->product->decrement('stock', $item->quantity);
                    }

                    $cart->active = false;
                    $cart->save();
                });
            }
        }

        return response('ok', 200);
    }
}
