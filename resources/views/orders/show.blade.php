@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Order #{{ $order->id }}</h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="md:col-span-2 bg-white rounded shadow p-4">
    <ul class="divide-y">
      @foreach($order->items as $item)
      <li class="py-2 flex justify-between">
        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
        <span>${{ number_format($item->unit_price * $item->quantity, 2) }}</span>
      </li>
      @endforeach
    </ul>
  </div>
  <div class="bg-white rounded shadow p-4">
    <div>Status: {{ ucfirst($order->status) }}</div>
    <div>Total: ${{ number_format($order->total,2) }}</div>
  </div>
</div>
@endsection
