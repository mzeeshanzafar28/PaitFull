<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
class LikeController extends Controller
{
    //function to add like on a post
    public function addLike(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'post_id' => 'required|exists:posts,id',
    ]);
    $like = Like::where('user_id', $request->user_id)
                ->where('post_id', $request->post_id)
                ->first();
    if ($like) {
        return response()->json(['message' => 'User has already liked this post.'], 400);
    }
    $like = new Like();
    $like->user_id = $request->user_id;
    $like->post_id = $request->post_id;
    $like->save();

    return response()->json(['message' => 'Post liked successfully.']);
}

}
