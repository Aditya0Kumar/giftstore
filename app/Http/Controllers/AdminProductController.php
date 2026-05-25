<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CustomizationOption;
use App\Models\PricingRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all unique categories to assist in autofill
        $categories = Product::select('category')->distinct()->pluck('category')->toArray();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:1000',
            'spec_keys' => 'array',
            'spec_values' => 'array',
            'options' => 'array', // Customization Options
            'rules' => 'array',   // Pricing Rules
        ]);

        DB::beginTransaction();

        try {
            $imageUrl = '/images/products/default.png';

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $imageUrl = asset('storage/' . $path);
            } elseif ($request->filled('image_url')) {
                $imageUrl = $request->image_url;
            }

            // Build specifications key-value array
            $specifications = [];
            if ($request->has('spec_keys') && $request->has('spec_values')) {
                foreach ($request->spec_keys as $index => $key) {
                    if (trim($key) !== '') {
                        $specifications[$key] = $request->spec_values[$index] ?? '';
                    }
                }
            }

            // Create Product
            $product = Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'base_price' => $request->base_price,
                'image_url' => $imageUrl,
                'rating' => 5.0,
                'reviews_count' => 0,
                'specifications' => $specifications,
            ]);

            // Save Customization Options
            if ($request->has('options')) {
                foreach ($request->options as $opt) {
                    if (isset($opt['name']) && trim($opt['name']) !== '') {
                        $values = null;
                        if (isset($opt['values']) && trim($opt['values']) !== '') {
                            $values = array_map('trim', explode(',', $opt['values']));
                        }
                        
                        $product->customizationOptions()->create([
                            'name' => $opt['name'],
                            'type' => $opt['type'] ?? 'text',
                            'values' => $values,
                        ]);
                    }
                }
            }

            // Save Pricing Rules
            if ($request->has('rules')) {
                foreach ($request->rules as $rule) {
                    if (isset($rule['condition_key']) && trim($rule['condition_key']) !== '') {
                        $product->pricingRules()->create([
                            'condition_key' => $rule['condition_key'],
                            'operator' => $rule['operator'] ?? '=',
                            'condition_value' => $rule['condition_value'] ?? '',
                            'price_adjustment' => $rule['price_adjustment'] ?? 0.0,
                            'type' => $rule['type'] ?? 'fixed',
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['customizationOptions', 'pricingRules']);
        $categories = Product::select('category')->distinct()->pluck('category')->toArray();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:1000',
            'spec_keys' => 'array',
            'spec_values' => 'array',
            'options' => 'array',
            'rules' => 'array',
        ]);

        DB::beginTransaction();

        try {
            $imageUrl = $product->image_url;

            if ($request->hasFile('image')) {
                // Delete old storage image if it was uploaded
                if (str_contains($product->image_url, '/storage/products/')) {
                    $oldPath = str_replace(asset('storage/'), '', $product->image_url);
                    Storage::disk('public')->delete($oldPath);
                }
                
                $path = $request->file('image')->store('products', 'public');
                $imageUrl = asset('storage/' . $path);
            } elseif ($request->filled('image_url')) {
                $imageUrl = $request->image_url;
            }

            // Build specifications key-value array
            $specifications = [];
            if ($request->has('spec_keys') && $request->has('spec_values')) {
                foreach ($request->spec_keys as $index => $key) {
                    if (trim($key) !== '') {
                        $specifications[$key] = $request->spec_values[$index] ?? '';
                    }
                }
            }

            // Update Product
            $product->update([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'base_price' => $request->base_price,
                'image_url' => $imageUrl,
                'specifications' => $specifications,
            ]);

            // Re-sync Customization Options (Delete and recreate)
            $product->customizationOptions()->delete();
            if ($request->has('options')) {
                foreach ($request->options as $opt) {
                    if (isset($opt['name']) && trim($opt['name']) !== '') {
                        $values = null;
                        if (isset($opt['values']) && trim($opt['values']) !== '') {
                            $values = array_map('trim', explode(',', $opt['values']));
                        }
                        
                        $product->customizationOptions()->create([
                            'name' => $opt['name'],
                            'type' => $opt['type'] ?? 'text',
                            'values' => $values,
                        ]);
                    }
                }
            }

            // Re-sync Pricing Rules (Delete and recreate)
            $product->pricingRules()->delete();
            if ($request->has('rules')) {
                foreach ($request->rules as $rule) {
                    if (isset($rule['condition_key']) && trim($rule['condition_key']) !== '') {
                        $product->pricingRules()->create([
                            'condition_key' => $rule['condition_key'],
                            'operator' => $rule['operator'] ?? '=',
                            'condition_value' => $rule['condition_value'] ?? '',
                            'price_adjustment' => $rule['price_adjustment'] ?? 0.0,
                            'type' => $rule['type'] ?? 'fixed',
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            // Delete image from storage if it exists
            if (str_contains($product->image_url, '/storage/products/')) {
                $path = str_replace(asset('storage/'), '', $product->image_url);
                Storage::disk('public')->delete($path);
            }

            $product->customizationOptions()->delete();
            $product->pricingRules()->delete();
            $product->reviews()->delete();
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.products.index')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
