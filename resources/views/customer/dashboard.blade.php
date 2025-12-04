<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Orders</div>
                    <div class="text-3xl font-bold">{{ $stats['total_orders'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Pending Orders</div>
                    <div class="text-3xl font-bold text-orange-600">{{ $stats['pending_orders'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Completed Orders</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['completed_orders'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Spent</div>
                    <div class="text-3xl font-bold">${{ number_format($stats['total_spent'], 2) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Cart Items</div>
                    <div class="text-3xl font-bold">{{ $stats['cart_items'] }}</div>
                    <a href="#" class="text-sm text-blue-600 hover:underline mt-2 inline-block">View Cart</a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Quick Actions</div>
                    <div class="mt-3 space-y-2">
                        <a href="#" class="block text-blue-600 hover:underline text-sm">Browse Products</a>
                        <a href="#" class="block text-blue-600 hover:underline text-sm">Track Orders</a>
                        <a href="#" class="block text-blue-600 hover:underline text-sm">Update Profile</a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Recent Orders</h3>
                </div>
                <div class="p-6">
                    @if ($recent_orders->count() > 0)
                        <div class="space-y-4">
                            @foreach ($recent_orders as $order)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <div class="font-semibold">{{ $order->order_number }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ $order->created_at->format('M d, Y h:i A') }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold">${{ number_format($order->total, 2) }}</div>
                                            <span
                                                class="px-2 py-1 text-xs rounded 
                                            {{ $order->status === 'delivered' ? 'bg-green-200 text-green-800' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-200 text-blue-800' : '' }}
                                            {{ $order->status === 'shipped' ? 'bg-purple-200 text-purple-800' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-200 text-red-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600 mb-2">
                                        <strong>Payment:</strong>
                                        <span
                                            class="px-2 py-1 text-xs rounded 
                                        {{ $order->payment_status === 'paid' ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                    <div class="border-t pt-2 mt-2">
                                        <div class="text-sm font-semibold mb-1">Items:</div>
                                        @foreach ($order->items as $item)
                                            <div class="text-sm text-gray-600">
                                                {{ $item->product->name }} (x{{ $item->quantity }}) -
                                                ${{ number_format($item->price, 2) }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No orders yet. Start shopping!</p>
                            <a href="#"
                                class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Browse Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
