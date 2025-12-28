@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Your Cart</h1>
<div class="bg-white rounded shadow">
  <table class="w-full">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">Product</th>
        <th class="p-3">Qty</th>
        <th class="p-3">Price</th>
        <th class="p-3">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($items as $item)
      <tr class="border-b">
        <td class="p-3">{{ $item->product->name }}</td>
        <td class="p-3">
          <form method="POST" action="{{ route('cart.update') }}" class="flex items-center space-x-2">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="border rounded px-2 py-1 w-20">
            <button class="text-sm bg-gray-800 text-white px-3 py-1 rounded">Update</button>
          </form>
        </td>
        <td class="p-3">${{ number_format($item->product->price,2) }}</td>
        <td class="p-3">
          <form method="POST" action="{{ route('cart.remove') }}">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <button class="text-sm text-red-600">Remove</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-4 grid md:grid-cols-3 gap-4">
  <div class="md:col-span-2">
    <form method="POST" action="{{ route('cart.applyCoupon') }}" class="flex space-x-2">
      @csrf
      <input type="text" name="code" placeholder="Coupon code" class="border rounded px-3 py-2">
      <button class="bg-gray-800 text-white px-4 py-2 rounded">Apply</button>
    </form>
  </div>
  <div class="bg-white rounded shadow p-4">
    <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($subtotal,2) }}</span></div>
    <div class="flex justify-between"><span>Discount</span><span>${{ number_format($discount,2) }}</span></div>
    <div class="flex justify-between font-semibold"><span>Total</span><span>${{ number_format($total,2) }}</span></div>
    <div class="mt-3 space-y-2">
      <a href="{{ route('checkout.show') }}" class="block bg-black text-white text-center px-4 py-2 rounded">Checkout</a>
    </div>
  </div>
</div>
@endsection
