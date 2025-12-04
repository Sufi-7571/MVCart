<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Category;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'total_users' => User::count(),
            'total_vendors' => Vendor::count(),
            'pending_vendors' => Vendor::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();
        $pending_vendors = Vendor::with('user')->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'pending_vendors'));
    }
}
