@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Coupon</h1>
<form method="POST" action="{{ route('admin.coupons.update', $coupon) }}" class="bg-white rounded shadow p-4 space-y-4">
  @csrf @method('PUT')
  <div>
    <label class="block text-sm mb-1">Code</label>
    <input name="code" value="{{ $coupon->code }}" class="border rounded px-3 py-2 w-full" required>
  </div>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="block text-sm mb-1">Type</label>
      <select name="type" class="border rounded px-3 py-2 w-full">
        <option value="percent" @if($coupon->type=='percent') selected @endif>percent</option>
        <option value="fixed" @if($coupon->type=='fixed') selected @endif>fixed</option>
      </select>
    </div>
    <div>
      <label class="block text-sm mb-1">Value</label>
      <input type="number" step="0.01" name="value" value="{{ $coupon->value }}" class="border rounded px-3 py-2 w-full" required>
    </div>
  </div>
  <div>
    <label class="inline-flex items-center space-x-2">
      <input type="checkbox" name="active" value="1" @if($coupon->active) checked @endif>
      <span>Active</span>
    </label>
  </div>
  <button class="bg-black text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
