<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $product->reviews()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        // Update product cached rating and count
        $avgRating = $product->reviews()->avg('rating');
        $reviewsCount = $product->reviews()->count();

        $product->update([
            'rating' => $avgRating,
            'reviews_count' => $reviewsCount,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
