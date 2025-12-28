@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
  <div class="md:col-span-2">
    <h2 class="text-xl font-semibold mb-3">Featured Products</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($featured as $p)
      <a href="{{ route('products.show', $p->slug) }}" class="bg-white rounded shadow p-3">
        <img src="{{ $p->image ?? '/demo-images/placeholder.svg' }}" class="w-full h-32 object-cover rounded mb-2">
        <div class="text-sm font-medium">{{ $p->name }}</div>
        <div class="text-gray-600">${{ number_format($p->price,2) }}</div>
      </a>
      @endforeach
    </div>
  </div>
  <div>
    <h2 class="text-xl font-semibold mb-3">Categories</h2>
    <ul class="bg-white rounded shadow divide-y">
      @foreach($categories as $c)
      <li class="p-3">
        <a href="{{ route('categories.show', $c->slug) }}" class="hover:underline">{{ $c->name }}</a>
      </li>
      @endforeach
    </ul>
  </div>
</div>
@endsection
