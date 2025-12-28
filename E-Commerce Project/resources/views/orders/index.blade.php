@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">My Orders</h1>
<div class="bg-white rounded shadow">
  <table class="w-full">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">ID</th>
        <th class="p-3">Status</th>
        <th class="p-3">Total</th>
        <th class="p-3"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $o)
      <tr class="border-b">
        <td class="p-3">{{ $o->id }}</td>
        <td class="p-3">{{ ucfirst($o->status) }}</td>
        <td class="p-3">${{ number_format($o->total,2) }}</td>
        <td class="p-3"><a href="{{ route('orders.show', $o->id) }}" class="text-indigo-600">View</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
