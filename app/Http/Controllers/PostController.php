<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Collection;

class PostController extends Controller
{
    /**
     * Display the homepage.
     */
    public function home()
    {
        $latestPosts = Post::with('category')
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $popularPosts = Post::with('category')
            ->where('status', 'published')
            ->orderByDesc('views')
            ->take(3)
            ->get();

        $categories = Category::withCount([
            'posts' => function ($query) {
                $query->where('status', 'published');
            }
        ])->get();

        return view('home', compact(
            'latestPosts',
            'popularPosts',
            'categories'
        ));
    }


    /**
     * Display a listing of published posts.
     */
    public function index(Request $request)
    {
        $query = Post::with([
            'category',
            'user',
            'tags',
        ])->where('status', 'published');

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::withCount([
            'posts' => function ($query) {
                $query->where('status', 'published');
            }
        ])->get();

        return view('posts.index', compact(
            'posts',
            'categories'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $collections = Collection::all();

        return view('posts.create', compact(
            'categories',
            'tags',
            'collections'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',

            // Recipe fields
            'prep_time' => 'nullable|integer|min:0|max:1440',
            'cook_time' => 'nullable|integer|min:0|max:1440',
            'servings' => 'nullable|integer|min:1|max:100',
            'calories' => 'nullable|integer|min:0|max:10000',
            'protein' => 'nullable|numeric|min:0|max:1000',

            // Recipe text fields
            'ingredients_text' => 'nullable|string',
            'instructions_text' => 'nullable|string',

            // Tags
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate a unique slug
        |--------------------------------------------------------------------------
        */

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;
        $validated['user_id'] = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | Convert recipe text into arrays
        |--------------------------------------------------------------------------
        */

        $validated['ingredients'] = collect(
            preg_split(
                '/\r\n|\r|\n/',
                $request->input('ingredients_text', '')
            )
        )
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $validated['instructions'] = collect(
            preg_split(
                '/\r\n|\r|\n/',
                $request->input('instructions_text', '')
            )
        )
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Remove form-only fields
        |--------------------------------------------------------------------------
        */

        unset(
            $validated['ingredients_text'],
            $validated['instructions_text']
        );


        /*
        |--------------------------------------------------------------------------
        | Store image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('posts', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Create post
        |--------------------------------------------------------------------------
        */

        $post = Post::create($validated);


        /*
        |--------------------------------------------------------------------------
        | Attach tags
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | Draft protection
        |--------------------------------------------------------------------------
        */

        if (
            $post->status === 'draft' &&
            auth()->id() !== $post->user_id
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Increment views
        |--------------------------------------------------------------------------
        */

        if ($post->status === 'published') {
            $post->increment('views');
        }


        /*
        |--------------------------------------------------------------------------
        | Load relationships
        |--------------------------------------------------------------------------
        */

        $post->load([
            'category',
            'user',
            'tags',
            'comments.user',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Like count
        |--------------------------------------------------------------------------
        */

        $likeCount = DB::table('likes')
            ->where('post_id', $post->id)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Check if current visitor already liked
        |--------------------------------------------------------------------------
        */

        if (auth()->check()) {

            // Registered user
            $hasLiked = DB::table('likes')
                ->where('post_id', $post->id)
                ->where('user_id', auth()->id())
                ->exists();

        } else {

            // Guest
            $guestToken = request()->cookie('yolkful_guest_token');

            $hasLiked = false;

            if ($guestToken) {
                $hasLiked = DB::table('likes')
                    ->where('post_id', $post->id)
                    ->where('guest_token', $guestToken)
                    ->exists();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Related posts
        |--------------------------------------------------------------------------
        */

        $relatedPosts = collect();

        if ($post->category_id) {
            $relatedPosts = Post::query()
                ->where('category_id', $post->category_id)
                ->where('status', 'published')
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(3)
                ->get();
        }


        return view('posts.show', compact(
            'post',
            'relatedPosts',
            'likeCount',
            'hasLiked'
        ));
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

        return view('posts.edit', compact(
            'post',
            'categories',
            'tags',
            'collections'
        ));
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',

            // Recipe fields
            'prep_time' => 'nullable|integer|min:0|max:1440',
            'cook_time' => 'nullable|integer|min:0|max:1440',
            'servings' => 'nullable|integer|min:1|max:100',
            'calories' => 'nullable|integer|min:0|max:10000',
            'protein' => 'nullable|numeric|min:0|max:1000',

            // Recipe text fields
            'ingredients_text' => 'nullable|string',
            'instructions_text' => 'nullable|string',

            // Tags
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate a unique slug
        |--------------------------------------------------------------------------
        */

        $baseSlug = Str::slug($validated['title']);

        $slug = $baseSlug;
        $counter = 2;

        while (
            Post::where('slug', $slug)
                ->where('id', '!=', $post->id)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;


        /*
        |--------------------------------------------------------------------------
        | Convert recipe text into arrays
        |--------------------------------------------------------------------------
        */

        $validated['ingredients'] = collect(
            preg_split(
                '/\r\n|\r|\n/',
                $request->input('ingredients_text', '')
            )
        )
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $validated['instructions'] = collect(
            preg_split(
                '/\r\n|\r|\n/',
                $request->input('instructions_text', '')
            )
        )
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Remove form-only fields
        |--------------------------------------------------------------------------
        */

        unset(
            $validated['ingredients_text'],
            $validated['instructions_text']
        );


        /*
        |--------------------------------------------------------------------------
        | Replace image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            // Delete old image
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Store new image
            $validated['image'] = $request
                ->file('image')
                ->store('posts', 'public');

        } else {

            // Keep current image
            unset($validated['image']);
        }


        /*
        |--------------------------------------------------------------------------
        | Update post
        |--------------------------------------------------------------------------
        */

        $post->update($validated);


        /*
        |--------------------------------------------------------------------------
        | Sync tags
        |--------------------------------------------------------------------------
        */

        $post->tags()->sync($request->input('tags', []));


        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'You are not authorized to delete this post.');
        }


        /*
        |--------------------------------------------------------------------------
        | Delete image
        |--------------------------------------------------------------------------
        */

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }


        /*
        |--------------------------------------------------------------------------
        | Delete post
        |--------------------------------------------------------------------------
        */

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully!');
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
            ->get([
                'id',
                'title',
                'image',
            ]);

        return response()->json(
            $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'url' => route('posts.show', $post->slug),
                    'image' => $post->image
                        ? asset('storage/' . $post->image)
                        : null,
                ];
            })
        );
    }


    /**
     * RSS feed of latest published posts.
     */
    public function rss()
    {
        $posts = Post::where('status', 'published')
            ->latest()
            ->take(20)
            ->get();

        return response()
            ->view('posts.rss', compact('posts'))
            ->header(
                'Content-Type',
                'application/rss+xml; charset=UTF-8'
            );
    }
}