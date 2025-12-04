<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\OrderItem;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;

        if (!$vendor) {
            return redirect()->route('dashboard')
                ->with('error', 'No vendor found.');
        }

        $stats = [
            'total_products' => Product::where('vendor_id', $vendor->id)->count(),
            'active_products' => Product::where('vendor_id', $vendor->id)->where('is_active', true)->count(),
            'out_of_stock_products' => Product::where('vendor_id', $vendor->id)->where('stock', 0)->count(),
            'total_orders' => OrderItem::where('vendor_id', $vendor->id)->distinct('order_id')->count('order_id'),
            'total_sales' => OrderItem::where('vendor_id', $vendor->id)->sum('vendor_amount'),
            'pending_commission' => OrderItem::where('vendor_id', $vendor->id)->sum('commission_amount'),
        ];

        $recent_products = Product::where('vendor_id', $vendor->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $recent_sales = OrderItem::where('vendor_id', $vendor->id)
            ->with(['order.user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact('vendor', 'stats', 'recent_products', 'recent_sales'));
    }
}
