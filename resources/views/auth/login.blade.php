@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-semibold mb-4">Login</h1>
    <form method="POST" action="/login" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <button class="bg-black text-white px-4 py-2 rounded">Login</button>
    </form>
    <p class="text-xs text-gray-500 mt-3">Default admin: admin@kinetiq.test / Admin123!</p>
 </div>
@endsection
