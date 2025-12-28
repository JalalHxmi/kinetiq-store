<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cart = $this->resolveCart($request);
        if (!$cart) {
            return redirect()->route('cart.show');
        }
        $items = $cart->items()->with('product')->get();
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        $discount = 0;
        if ($cart->coupon) {
            $discount = $cart->coupon->type === 'percent'
                ? $subtotal * ($cart->coupon->value / 100)
                : $cart->coupon->value;
        }
        $total = max(0, $subtotal - $discount);
        return view('checkout.show', compact('cart', 'items', 'subtotal', 'discount', 'total'));
    }

    public function stripeCheckout(Request $request)
    {
        $cart = $this->resolveCart($request);
        if (!$cart) {
            return redirect()->route('cart.show');
        }
        $line_items = [];
        $subtotal = 0;
        foreach ($cart->items()->with('product')->get() as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => (int) round($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
            $subtotal += $item->product->price * $item->quantity;
        }
        $discount = 0;
        if ($cart->coupon) {
            $discount = $cart->coupon->type === 'percent'
                ? $subtotal * ($cart->coupon->value / 100)
                : $cart->coupon->value;
        }
        $total = max(0, $subtotal - $discount);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'success_url' => url('/order/confirm/{CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/cart'),
            'metadata' => [
                'cart_id' => (string) $cart->id,
            ],
        ]);
        return redirect()->away($session->url);
    }

    public function codCheckout(Request $request)
    {
        if (!env('COD_ENABLED', true)) {
            return back()->withErrors(['cod' => 'COD is disabled']);
        }

        $cart = $this->resolveCart($request);
        if (!$cart) {
            return redirect()->route('cart.show');
        }

        $items = $cart->items()->with('product')->get();
        DB::transaction(function () use ($cart, $items) {
            $subtotal = 0;
            foreach ($items as $item) {
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
                'email' => $request->user()?->email ?? 'guest@unknown.local',
                'status' => 'pending',
                'payment_method' => 'cod',
                'coupon_id' => $cart->coupon_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
            ]);

            foreach ($items as $item) {
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

        return redirect()->route('order.confirm', ['order' => Order::latest()->first()->id]);
    }

    public function confirm(Order $order)
    {
        return view('checkout.confirm', compact('order'));
    }

    private function resolveCart(Request $request): ?Cart
    {
        $user = $request->user();
        if ($user) {
            return Cart::where('user_id', $user->id)->where('active', true)->first();
        }
        $sid = $request->session()->getId();
        return Cart::where('session_id', $sid)->where('active', true)->first();
    }
}
