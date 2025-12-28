@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
  <img src="{{ $product->image ?? '/demo-images/placeholder.svg' }}" class="w-full h-80 object-cover rounded">
  <div>
    <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
    <div class="text-gray-700 mt-2">${{ number_format($product->price,2) }}</div>
    <p class="mt-4 text-sm text-gray-600">{{ $product->description }}</p>
    <form method="POST" action="{{ route('cart.add') }}" class="mt-4 space-x-2">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <input type="number" name="quantity" value="1" min="1" class="border rounded px-3 py-2 w-24">
      <button class="bg-black text-white px-4 py-2 rounded">Add to Cart</button>
    </form>
  </div>
@endsection
