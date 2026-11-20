<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts'   => Product::count(),
            'totalCategories' => Category::count(),
            'categories'      => Category::withCount('products')->orderBy('name')->get(),
            'latest'          => Product::with('category')->latest()->take(5)->get(),
        ]);
    }
}