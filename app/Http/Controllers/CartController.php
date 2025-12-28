<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $cart = $this->resolveCart($request, createIfMissing: true);
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
        return view('cart.show', compact('cart', 'items', 'subtotal', 'discount', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = $this->resolveCart($request, createIfMissing: true);
        $item = $cart->items()->where('product_id', $request->product_id)->first();
        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        return redirect()->route('cart.show');
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $item = CartItem::findOrFail($request->item_id);
        $item->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.show');
    }

    public function remove(Request $request)
    {
        $request->validate(['item_id' => 'required|exists:cart_items,id']);
        $item = CartItem::findOrFail($request->item_id);
        $item->delete();
        return redirect()->route('cart.show');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required']);
        $cart = $this->resolveCart($request, createIfMissing: true);
        $coupon = Coupon::where('code', $request->code)->where('active', true)->first();
        if (!$coupon) {
            return back()->withErrors(['code' => 'Invalid coupon']);
        }
        $cart->coupon()->associate($coupon);
        $cart->save();
        return redirect()->route('cart.show');
    }

    private function resolveCart(Request $request, bool $createIfMissing = false): Cart
    {
        $user = $request->user();
        $query = $user
            ? Cart::where('user_id', $user->id)->where('active', true)
            : Cart::where('session_id', $request->session()->getId())->where('active', true);

        $cart = $query->first();
        if (!$cart && $createIfMissing) {
            $cart = Cart::create([
                'user_id' => $user?->id,
                'session_id' => $user ? null : $request->session()->getId(),
                'active' => true,
            ]);
        }
        return $cart;
    }
}
