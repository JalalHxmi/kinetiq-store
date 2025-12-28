@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">New Category</h1>
<form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white rounded shadow p-4 space-y-4">
  @csrf
  <div>
    <label class="block text-sm mb-1">Name</label>
    <input name="name" class="border rounded px-3 py-2 w-full" required>
  </div>
  <button class="bg-black text-white px-4 py-2 rounded">Save</button>
</form>
@endsection
