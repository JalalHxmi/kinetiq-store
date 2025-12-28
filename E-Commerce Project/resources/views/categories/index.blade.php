@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Categories</h1>
<ul class="grid grid-cols-2 md:grid-cols-3 gap-4">
@foreach($categories as $c)
  <li class="bg-white rounded shadow p-3">
    <a href="{{ route('categories.show', $c->slug) }}" class="font-medium hover:underline">{{ $c->name }}</a>
  </li>
@endforeach
</ul>
@endsection
