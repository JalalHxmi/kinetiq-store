@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Product</h1>
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white rounded shadow p-4 space-y-4">
  @csrf @method('PUT')
  <div>
    <label class="block text-sm mb-1">Name</label>
    <input name="name" value="{{ $product->name }}" class="border rounded px-3 py-2 w-full" required>
  </div>
  <div>
    <label class="block text-sm mb-1">Category</label>
    <select name="category_id" class="border rounded px-3 py-2 w-full" required>
      @foreach($categories as $c)
      <option value="{{ $c->id }}" @if($product->category_id==$c->id) selected @endif>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm mb-1">Price</label>
      <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="border rounded px-3 py-2 w-full" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Stock</label>
      <input type="number" name="stock" value="{{ $product->stock }}" class="border rounded px-3 py-2 w-full" required>
    </div>
  </div>
  <div>
    <label class="block text-sm mb-1">Description</label>
    <textarea name="description" class="border rounded px-3 py-2 w-full">{{ $product->description }}</textarea>
  </div>
  <div>
    <label class="block text-sm mb-1">Image</label>
    <input type="file" name="image" class="border rounded px-3 py-2 w-full">
  </div>
  <button class="bg-black text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
