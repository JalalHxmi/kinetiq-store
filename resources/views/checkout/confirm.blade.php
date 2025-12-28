@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-6 text-center">
  <h1 class="text-2xl font-semibold mb-2">Order Confirmed</h1>
  <p class="text-gray-600">Order #{{ $order->id }} — Status: {{ ucfirst($order->status) }}</p>
  <p class="mt-2">Total: ${{ number_format($order->total,2) }}</p>
  <a href="/" class="mt-4 inline-block bg-black text-white px-4 py-2 rounded">Continue Shopping</a>
</div>
@endsection
