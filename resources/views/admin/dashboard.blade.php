<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Users</div>
                    <div class="text-3xl font-bold">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Vendors</div>
                    <div class="text-3xl font-bold">{{ $stats['total_vendors'] }}</div>
                    <div class="text-orange-600 text-xs mt-1">{{ $stats['pending_vendors'] }} Pending</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Products</div>
                    <div class="text-3xl font-bold">{{ $stats['total_products'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Orders</div>
                    <div class="text-3xl font-bold">{{ $stats['total_orders'] }}</div>
                    <div class="text-orange-600 text-xs mt-1">{{ $stats['pending_orders'] }} Pending</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Revenue</div>
                    <div class="text-3xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Categories</div>
                    <div class="text-3xl font-bold">{{ $stats['total_categories'] }}</div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Recent Orders</h3>
                </div>
                <div class="p-6">
                    @if ($recent_orders->count() > 0)
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Order #</th>
                                    <th class="text-left py-2">Customer</th>
                                    <th class="text-left py-2">Total</th>
                                    <th class="text-left py-2">Status</th>
                                    <th class="text-left py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_orders as $order)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $order->order_number }}</td>
                                        <td class="py-2">{{ $order->user->name }}</td>
                                        <td class="py-2">${{ number_format($order->total, 2) }}</td>
                                        <td class="py-2">
                                            <span
                                                class="px-2 py-1 text-xs rounded bg-gray-200">{{ $order->status }}</span>
                                        </td>
                                        <td class="py-2">{{ $order->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No orders yet.</p>
                    @endif
                </div>
            </div>

            <!-- Pending Vendors -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold">Pending Vendor Approvals</h3>
                </div>
                <div class="p-6">
                    @if ($pending_vendors->count() > 0)
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Shop Name</th>
                                    <th class="text-left py-2">Owner</th>
                                    <th class="text-left py-2">Email</th>
                                    <th class="text-left py-2">Applied On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pending_vendors as $vendor)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $vendor->shop_name }}</td>
                                        <td class="py-2">{{ $vendor->user->name }}</td>
                                        <td class="py-2">{{ $vendor->user->email }}</td>
                                        <td class="py-2">{{ $vendor->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No pending vendors.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
