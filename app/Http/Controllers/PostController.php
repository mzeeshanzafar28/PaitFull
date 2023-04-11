<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function addPost(Request $request)
    {
        $request->validate([
            'files' => 'required|mimes:jpg,jpeg,png,mp4,gif',
            'description' => 'required',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();

        $files = $request->file('files');
        $filesArray = [];
        if ($request->hasFile('files')) {
            foreach ($files as $file) {
                $fileName = time() . '_' . str_replace(" ", "_", $file->getClientOriginalName());
                $file->move(public_path('uploads'), $fileName);
                $filePath = '/uploads/' . $fileName;

                $fileObject = [
                    'name' => $fileName,
                    'type' => $file->getClientOriginalExtension(),
                    'path' => $filePath,
                ];

                array_push($filesArray, $fileObject);
            }
        }
        $post->files = json_encode($filesArray);
        $post->description = $request->description;
        $post->save();
        return response()->json(['message' => 'Success', 'post' => $post]);
    }

    public function deletePost(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
        ]);
        $post = Post::find($request->id);
        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.']);
    }


}