<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featured_products = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with(['vendor', 'category', 'primaryImage'])
            ->latest()
            ->take(8)
            ->get();

        $latest_products = Product::where('is_active', true)
            ->with(['vendor', 'category', 'primaryImage'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('order')
            ->take(6)
            ->get();

        return view('home', compact('featured_products', 'latest_products', 'categories'));
    }
}
