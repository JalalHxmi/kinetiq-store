@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Products</h1>
  <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-4 py-2 rounded">New</a>
  <form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data" class="ml-4">
    @csrf
    <input type="file" name="file" class="border px-2 py-1">
    <button class="bg-gray-800 text-white px-3 py-1 rounded">Import CSV</button>
  </form>
</div>
<div class="bg-white rounded shadow">
  <table class="w-full">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">Name</th>
        <th class="p-3">Price</th>
        <th class="p-3">Stock</th>
        <th class="p-3"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $p)
      <tr class="border-b">
        <td class="p-3">{{ $p->name }}</td>
        <td class="p-3">${{ number_format($p->price,2) }}</td>
        <td class="p-3">{{ $p->stock }}</td>
        <td class="p-3">
          <a href="{{ route('admin.products.edit', $p) }}" class="text-indigo-600">Edit</a>
          <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="inline">
            @csrf @method('DELETE')
            <button class="text-red-600">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
