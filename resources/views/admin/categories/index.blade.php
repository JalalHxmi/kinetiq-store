@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Categories</h1>
  <a href="{{ route('admin.categories.create') }}" class="bg-black text-white px-4 py-2 rounded">New</a>
</div>
<div class="bg-white rounded shadow">
  <table class="w-full">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">Name</th>
        <th class="p-3"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $c)
      <tr class="border-b">
        <td class="p-3">{{ $c->name }}</td>
        <td class="p-3">
          <a href="{{ route('admin.categories.edit', $c) }}" class="text-indigo-600">Edit</a>
          <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="inline">
            @csrf @method('DELETE')
            <button class="text-red-600">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $categories->links() }}</div>
@endsection
