<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return Post::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);
    }

    public function show($slug)
    {
        return Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'cover_image' => $request->cover_image,
            'status' => $request->status ?? 'draft',
            'published_at' => $request->status === 'published' ? now() : null,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($post, 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
