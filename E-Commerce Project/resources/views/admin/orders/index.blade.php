@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Orders</h1>
<div class="bg-white rounded shadow">
  <table class="w-full">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">ID</th>
        <th class="p-3">Email</th>
        <th class="p-3">Status</th>
        <th class="p-3">Total</th>
        <th class="p-3">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $o)
      <tr class="border-b">
        <td class="p-3">{{ $o->id }}</td>
        <td class="p-3">{{ $o->email }}</td>
        <td class="p-3">{{ ucfirst($o->status) }}</td>
        <td class="p-3">${{ number_format($o->total,2) }}</td>
        <td class="p-3">
          <form method="POST" action="{{ route('admin.orders.updateStatus', $o) }}" class="inline">
            @csrf @method('PUT')
            <select name="status" class="border rounded px-2 py-1">
              <option value="pending">pending</option>
              <option value="paid">paid</option>
              <option value="shipped">shipped</option>
              <option value="delivered">delivered</option>
              <option value="cancelled">cancelled</option>
            </select>
            <button class="text-indigo-600">Update</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
