<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/calculate-price', function (Request $request, \App\Services\PricingService $pricingService) {
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'customization' => 'array',
    ]);

    $product = \App\Models\Product::findOrFail($request->product_id);
    $price = $pricingService->calculatePrice($product, $request->customization ?? []);

    return response()->json(['price' => $price]);
});

Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class)->names('api.products');
