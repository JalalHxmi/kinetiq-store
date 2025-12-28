<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Stripe\StripeClient;
use Illuminate\Support\Str;

class StripeController extends Controller
{
    public function createSession(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $cart = $this->resolveCart($request);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
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

        return response()->json(['id' => $session->id, 'url' => $session->url]);
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
