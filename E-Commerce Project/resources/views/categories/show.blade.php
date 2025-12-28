@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">{{ $category->name }}</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
@foreach($products as $p)
  <a href="{{ route('products.show', $p->slug) }}" class="bg-white rounded shadow p-3">
    <img src="{{ $p->image ?? '/demo-images/placeholder.svg' }}" class="w-full h-32 object-cover rounded mb-2">
    <div class="text-sm font-medium">{{ $p->name }}</div>
    <div class="text-gray-600">${{ number_format($p->price,2) }}</div>
  </a>
@endforeach
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
