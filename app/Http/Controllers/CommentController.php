<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Validation for the incoming request data
        $validated = $request->validate([
            'comment_text' => 'required|string|max:255',
        ]);

        // Create a new comment and associate it with the post
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->comment_text = $validated['comment_text'];
        $comment->save();

        // Optionally, return a response or redirect
        return redirect()->route('posts.index', $post->id)->with('success', 'Comment added successfully.');
    }
}
