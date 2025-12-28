<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="font-bold text-xl">{{ config('app.name') }}</a>
            <nav class="space-x-4">
                <a href="{{ route('products.index') }}" class="hover:underline">Products</a>
                <a href="{{ route('cart.show') }}" class="hover:underline">Cart</a>
                @auth
                    <a href="{{ route('orders.index') }}" class="hover:underline">My Orders</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                @endauth
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4 py-6">
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif
        @yield('content')
    </main>
    <footer class="border-t mt-10 py-6 text-center text-sm text-gray-500">
        © {{ date('Y') }} {{ config('app.name') }}
    </footer>
</body>
</html>
