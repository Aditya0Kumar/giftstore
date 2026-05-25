<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\PricingService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, PricingService $pricingService)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customization' => 'array',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $customization = [];
        if ($request->has('customization') || $request->hasFile('customization')) {
            $inputs = $request->input('customization', []);
            $files = $request->file('customization', []);
            $allKeys = array_unique(array_merge(array_keys($inputs), array_keys($files)));

            foreach ($allKeys as $key) {
                if ($request->hasFile("customization.{$key}")) {
                    $file = $request->file("customization.{$key}");
                    $path = $file->store('customizations', 'public');
                    $customization[$key] = asset('storage/' . $path);
                } elseif (isset($inputs[$key])) {
                    $customization[$key] = $inputs[$key];
                }
            }
        }
        
        $price = $pricingService->calculatePrice($product, $customization);
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);
        
        // Use a unique ID for the cart item since same product can have different customizations
        $cartItemId = uniqid();

        $cart[$cartItemId] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $price,
            'quantity' => $quantity,
            'customization' => $customization,
            'image_url' => $product->image_url,
        ];

        session()->put('cart', $cart);

        // Cookie for last viewed product
        cookie()->queue('last_viewed_product', $product->id, 60 * 24 * 7);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => count(session()->get('cart', []))
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }
}
