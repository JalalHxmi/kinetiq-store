@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Coupons</h1>
  <a href="{{ route('admin.coupons.create') }}" class="bg-black text-white px-4 py-2 rounded">New</a>
</div>
<div class="bg-white rounded shadow">
  <table class="w-full">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">Code</th>
        <th class="p-3">Type</th>
        <th class="p-3">Value</th>
        <th class="p-3">Active</th>
        <th class="p-3"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($coupons as $c)
      <tr class="border-b">
        <td class="p-3">{{ $c->code }}</td>
        <td class="p-3">{{ $c->type }}</td>
        <td class="p-3">{{ $c->value }}</td>
        <td class="p-3">{{ $c->active ? 'Yes' : 'No' }}</td>
        <td class="p-3">
          <a href="{{ route('admin.coupons.edit', $c) }}" class="text-indigo-600">Edit</a>
          <form method="POST" action="{{ route('admin.coupons.destroy', $c) }}" class="inline">
            @csrf @method('DELETE')
            <button class="text-red-600">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $coupons->links() }}</div>
@endsection
