<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $wishlist = Auth::user()->wishlists()->where('product_id', $product->id)->first();
        $isAdded = false;

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Product removed from wishlist.';
        } else {
            Auth::user()->wishlists()->create([
                'product_id' => $product->id
            ]);
            $isAdded = true;
            $message = 'Product added to wishlist.';
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'added' => $isAdded,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }

    public function remove(Product $product)
    {
        Auth::user()->wishlists()->where('product_id', $product->id)->delete();
        $message = 'Product removed from wishlist.';

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}
