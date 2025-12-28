@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Admin Dashboard</h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="bg-white rounded shadow p-4">
    <div class="text-sm text-gray-500">Total Sales</div>
    <div class="text-2xl font-bold">${{ number_format($totalSales,2) }}</div>
  </div>
  <div class="bg-white rounded shadow p-4">
    <div class="text-sm text-gray-500">Orders Today</div>
    <div class="text-2xl font-bold">{{ $ordersToday }}</div>
  </div>
  <div class="bg-white rounded shadow p-4">
    <div class="text-sm text-gray-500">Pending Orders</div>
    <div class="text-2xl font-bold">{{ $pendingOrders }}</div>
  </div>
</div>
@endsection
