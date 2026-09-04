<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Collection;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display the homepage.
     */
    public function home()
    {
        $latestPosts = Post::where('status', 'published')->latest()->take(6)->get();
        $popularPosts = Post::where('status', 'published')->orderByDesc('views')->take(3)->get();

        return view('home', compact('latestPosts', 'popularPosts'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::where('status', 'published');
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        $posts = $query->latest()->paginate(10)->withQueryString();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $collections = Collection::all();
        return view('posts.create', compact('categories', 'tags', 'collections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);
        $validated['slug'] = Str::slug($request->title);
        $validated['user_id'] = auth()->id();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validated);

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if ($post->status === 'draft' && auth()->id() !== $post->user_id) {
            abort(404);
        }

        if ($post->status === 'published') {
            $post->increment('views');
        }

        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'You are not authorized to edit this post.');
        }

        $categories = Category::all();
        $tags = Tag::all();
        $collections = Collection::all();
        return view('posts.edit', compact('post', 'categories', 'tags', 'collections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'You are not authorized to edit this post.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);
        $validated['slug'] = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        } else {
            unset($validated['image']);
        }

        $post->update($validated);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]);
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'You are not authorized to delete this post.');
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

     /**
     * Return live search suggestions as JSON.
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $posts = Post::where('status', 'published')
            ->where('title', 'like', "%{$query}%")
            ->latest()
            ->take(5)
            ->get(['id', 'title', 'image']);

        return response()->json($posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'url' => route('posts.show', $post->id),
                'image' => $post->image ? asset('storage/' . $post->image) : null,
            ];
        }));
    }

    /**
     * RSS feed of latest published posts.
     */
    public function rss()
    {
        $posts = Post::where('status', 'published')->latest()->take(20)->get();

        return response()->view('posts.rss', compact('posts'))
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

   

}