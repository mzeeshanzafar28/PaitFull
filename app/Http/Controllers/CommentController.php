<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
//function to add comment on a post
    public function addComment(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'post_id'=>'required',
            'is_reply'=>'required',
            'comment'=>'required',
            'comment_id'=>'required'
        ]);

        $user = User::find($request->user_id);
        $post = Post::find($request->post_id);
        if (!$user)
        {
            return response()->json(['message' => 'User not found']);
        }
        if (!$post)
        {
            return response()->json(['message' => 'Post not found']);
        }
        
        $comment  = new Comment();
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->is_reply = $request->is_reply;
        $comment->comment = $request->comment;
        $comment->comment_id = $request->comment_id;
        $comment->save();
        return response()->json(['message' => 'comment created', 'comment' => $comment]);
}

}