<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MVCart - Multi Vendor Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">MVCart</a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-4">Welcome to MVCart</h1>
            <p class="text-xl mb-8">Your One-Stop Multi-Vendor Marketplace</p>
            <div class="flex justify-center space-x-4">
                <a href="#products"
                    class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">Shop Now</a>
                <a href="{{ route('register') }}"
                    class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600">Become
                    a Vendor</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if ($categories->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach ($categories as $category)
                        <a href="#" class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 text-center">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="w-16 h-16 mx-auto mb-3 object-cover rounded">
                            @else
                                <div
                                    class="w-16 h-16 mx-auto mb-3 bg-blue-100 rounded flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <h3 class="font-semibold">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->products_count }} items</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Products Section -->
    @if ($featured_products->count() > 0)
        <section class="py-16" id="products">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($featured_products as $product)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                            <div class="h-48 bg-gray-200 relative">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image) }}"
                                        alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                @if ($product->hasDiscount())
                                    <span
                                        class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">SALE</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-1 truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $product->vendor->shop_name }}</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if ($product->hasDiscount())
                                            <span
                                                class="text-lg font-bold text-red-600">${{ number_format($product->discount_price, 2) }}</span>
                                            <span
                                                class="text-sm text-gray-400 line-through ml-1">${{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span
                                                class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <button class="mt-3 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Add to
                                    Cart</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Latest Products Section -->
    @if ($latest_products->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Latest Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($latest_products as $product)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                            <div class="h-48 bg-gray-200 relative">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image) }}"
                                        alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                @if ($product->hasDiscount())
                                    <span
                                        class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">SALE</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-1 truncate">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $product->vendor->shop_name }}</p>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if ($product->hasDiscount())
                                            <span
                                                class="text-lg font-bold text-red-600">${{ number_format($product->discount_price, 2) }}</span>
                                            <span
                                                class="text-sm text-gray-400 line-through ml-1">${{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span
                                                class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <button class="mt-3 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Add to
                                    Cart</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</body>

</html>
