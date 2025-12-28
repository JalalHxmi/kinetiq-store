@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Checkout</h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="md:col-span-2 bg-white rounded shadow p-4">
    <h2 class="font-semibold mb-2">Order Summary</h2>
    <ul class="divide-y">
      @foreach($items as $item)
      <li class="py-2 flex justify-between">
        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
        <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
      </li>
      @endforeach
    </ul>
  </div>
  <div class="bg-white rounded shadow p-4">
    <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($subtotal,2) }}</span></div>
    <div class="flex justify-between"><span>Discount</span><span>${{ number_format($discount,2) }}</span></div>
    <div class="flex justify-between font-semibold"><span>Total</span><span>${{ number_format($total,2) }}</span></div>
    <div class="mt-3 space-y-2">
      <form method="POST" action="{{ route('checkout.cod') }}">
        @csrf
        <button class="w-full bg-gray-900 text-white px-4 py-2 rounded">Cash on Delivery</button>
      </form>
      <form method="POST" action="{{ route('checkout.stripe') }}">
        @csrf
        <button class="w-full bg-indigo-600 text-white px-4 py-2 rounded">Pay with Stripe</button>
      </form>
    </div>
  </div>
</div>
@endsection
