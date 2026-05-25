<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $categories = Product::select('category')->distinct()->pluck('category');
        $products = $query->paginate(12)->withQueryString();
        $wishlistedIds = auth()->check() ? auth()->user()->wishlists->pluck('product_id')->toArray() : [];

        return view('products.index', compact('products', 'categories', 'wishlistedIds'));
    }

    public function show(Product $product)
    {
        $product->load(['customizationOptions', 'reviews.user']);
        $wishlistedIds = auth()->check() ? auth()->user()->wishlists->pluck('product_id')->toArray() : [];
        
        $similarProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'wishlistedIds', 'similarProducts'));
    }
}
