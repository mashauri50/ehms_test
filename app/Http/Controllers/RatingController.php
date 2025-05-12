<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\UserRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
   
     // Rate or update a product
    public function rateProduct(Request $request, $productId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $rating = UserRating::updateOrCreate(
            ['user_id' => $request->user_id, 'product_id' => $productId],
            ['rating' => $request->rating, 'rating_datetime' => now()]
        );

        return response()->json(['message' => 'Rating saved successfully.', 'data' => $rating]);
    }

    // Remove a rating
    public function removeRating(Request $request, $productId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $rating = UserRating::where('user_id', $request->user_id)
                            ->where('product_id', $productId)
                            ->first();

        if ($rating) {
            $rating->delete();
            return response()->json(['message' => 'Rating removed successfully.']);
        }

        return response()->json(['message' => 'Rating not found.'], 404);
    }

    // changeRating
    public function changeRating(Request $request, $productId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $existingRating = UserRating::where('user_id', $request->input('user_id'))
            ->where('product_id', $productId)
            ->first();

        if ($existingRating) {
            $existingRating->rating = $request->input('rating');
            $existingRating->rating_datetime = now();
            $existingRating->save();

            return response()->json([
                'message' => 'Rating updated successfully.',
                'data' => $existingRating
            ]);
        } else {
            return response()->json([
                'message' => 'No existing rating found to update.'
            ], 404);
        }
    }



    // List products with average rating, user rating, time passed, and active time
    public function listProducts(Request $request)
    {


        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $userId = $request->user_id;

        $products = Product::with('ratings')->get()->map(function ($product) use ($userId) {
            $averageRating = $product->ratings->avg('rating');
            $userRating = $product->ratings->firstWhere('user_id', $userId);

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'ratings' => round($averageRating, 2),
                'user_rating' => $userRating?->rating,
                'time_passed' => $userRating 
                    ? Carbon::parse($userRating->rating_datetime)->diffInMinutes(now()) . ' minutes ago'
                    : null,
                'active_time' => $userRating
                    ? now()->diffForHumans(Carbon::parse($userRating->rating_datetime), true)
                    : null,
            ];
        });

        return response()->json($products);
    
    }
}
