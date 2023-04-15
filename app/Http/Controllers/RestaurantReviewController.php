<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RestaurantReview;
use Illuminate\Support\Facades\Auth;

class RestaurantReviewController extends Controller
{
    //add a new restaurant review or manage an existing one
    public function manageRestaurantReview(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|exists:users,id',
                'restaurant_id' => 'required:exists:restaurants,id',
                'review' => 'required',
                'rating' => 'required'
            ]
        );

        $review = RestaurantReview::where('user_id', Auth::id())
                    ->where('restaurant_id', $request->Restaurant_id)
                    ->first();

        if (!$review){
            $review = new RestaurantReview();
            $review->user_id = Auth::id();
            $review->restaurant_id = $request->restaurant_id;
        }
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();
        return response()->json(['message' => 'Success', 'review' => $review]);
    }

    //delete an existing review
    public function deleteRestaurantReview(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:restaurant_reviews,id',
        ]);
        $review = RestaurantReview::find($request->id);
        if ($review)
        {
            $review->delete();
            return response()->json(['message' =>'Review deleted successfully']);
        }
        return response()->json(['message' =>'Review does not exist']);
    }
}
