<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /** Beranda */
    public function index()
    {
        return view('public.home', [
            'featured'        => Product::with('category')->latest()->take(6)->get(),
            'totalProducts'   => Product::count(),
            'totalCategories' => Category::count(),
        ]);
    }

    /** Profil usaha */
    public function profile()
    {
        return view('public.profile', [
            'categories'    => Category::withCount('products')->orderBy('name')->get(),
            'totalProducts' => Product::count(),
        ]);
    }

    /** Katalog produk (pencarian + filter kategori + pagination) */
    public function catalog(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $slug    = $request->query('kategori');

        $categories = Category::withCount('products')->orderBy('name')->get();

        $products = Product::with('category')
            ->when($slug, fn ($query) => $query->whereHas('category', fn ($q) => $q->where('slug', $slug)))
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('public.catalog', [
            'categories'     => $categories,
            'products'       => $products,
            'activeCategory' => $slug,
            'keyword'        => $keyword,
            'totalProducts'  => Product::count(),
        ]);
    }

    /** Detail produk */
    public function show(Product $product)
    {
        $product->load('category');

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.show', compact('product', 'related'));
    }
}