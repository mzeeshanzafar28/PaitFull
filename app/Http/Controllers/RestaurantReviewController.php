<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RestaurantReview;
class RestaurantReviewController extends Controller
{
    public function manageRestaurantReview(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required',
                'restaurant_id' => 'required',
                'review' => 'required',
                'rating' => 'required'
            ]
        );

        $review = RestaurantReview::where('user_id', $request->user_id)
                    ->where('restaurant_id', $request->Restaurant_id)
                    ->first();

        if (!$review){
            $review = new RestaurantReview();
            $review->user_id = $request->user_id;
            $review->restaurant_id = $request->restaurant_id;
        }
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();
        return response()->json(['message' => 'Success', 'review' => $review]);
    }

    public function deleteRestaurantReview(Request $request)
    {
        $review = RestaurantReview::find($request->id);
        if ($review)
        {
            $review->delete();
            return response()->json(['message' =>'Review deleted successfully']);
        }
        return response()->json(['message' =>'Review does not exist']);
    }
}
