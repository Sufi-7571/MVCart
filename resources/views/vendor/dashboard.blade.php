<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendor Dashboard') }} - {{ $vendor->shop_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Vendor Status Alert -->
            @if ($vendor->status !== 'approved')
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Your vendor account is <strong>{{ $vendor->status }}</strong>.
                                @if ($vendor->status === 'pending')
                                    Please wait for admin approval.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Products</div>
                    <div class="text-3xl font-bold">{{ $stats['total_products'] }}</div>
                    <div class="text-green-600 text-xs mt-1">{{ $stats['active_products'] }} Active</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Sales</div>
                    <div class="text-3xl font-bold">${{ number_format($stats['total_sales'], 2) }}</div>
                    <div class="text-gray-600 text-xs mt-1">{{ $stats['total_orders'] }} Orders</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Out of Stock</div>
                    <div class="text-3xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</div>
                    <div class="text-gray-600 text-xs mt-1">Products need restocking</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Platform Commission</div>
                    <div class="text-2xl font-bold">${{ number_format($stats['pending_commission'], 2) }}</div>
                    <div class="text-gray-600 text-xs mt-1">Total paid to platform ({{ $vendor->commission_rate }}%)
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Shop Status</div>
                    <div class="text-2xl font-bold capitalize">{{ $vendor->status }}</div>
                    <div class="text-gray-600 text-xs mt-1">Commission Rate: {{ $vendor->commission_rate }}%</div>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Recent Products</h3>
                </div>
                <div class="p-6">
                    @if ($recent_products->count() > 0)
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Product Name</th>
                                    <th class="text-left py-2">Category</th>
                                    <th class="text-left py-2">Price</th>
                                    <th class="text-left py-2">Stock</th>
                                    <th class="text-left py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_products as $product)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $product->name }}</td>
                                        <td class="py-2">{{ $product->category->name }}</td>
                                        <td class="py-2">${{ number_format($product->price, 2) }}</td>
                                        <td class="py-2">{{ $product->stock }}</td>
                                        <td class="py-2">
                                            <span
                                                class="px-2 py-1 text-xs rounded {{ $product->is_active ? 'bg-green-200' : 'bg-red-200' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No products yet. Add your first product!</p>
                    @endif
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Recent Sales</h3>
                </div>
                <div class="p-6">
                    @if ($recent_sales->count() > 0)
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Order #</th>
                                    <th class="text-left py-2">Product</th>
                                    <th class="text-left py-2">Customer</th>
                                    <th class="text-left py-2">Quantity</th>
                                    <th class="text-left py-2">Your Amount</th>
                                    <th class="text-left py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_sales as $sale)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $sale->order->order_number }}</td>
                                        <td class="py-2">{{ $sale->product->name }}</td>
                                        <td class="py-2">{{ $sale->order->user->name }}</td>
                                        <td class="py-2">{{ $sale->quantity }}</td>
                                        <td class="py-2">${{ number_format($sale->vendor_amount, 2) }}</td>
                                        <td class="py-2">{{ $sale->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No sales yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
