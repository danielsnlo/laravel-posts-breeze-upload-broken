<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated = $request->validate([
            'content' => 'required|string|nax:500',
        ]);

        $post = new Post();
        $post->user = Auth::id();
        $post->title = $request->title;
        $post->content = $request->content;

        $post->comments()->create([
            'content' => $validated['content'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $post->image_path = $path;
        }

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->latest()->get(); // This gets comments for post
        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // dd($post);
        // var_dump
        $post->delete();
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
