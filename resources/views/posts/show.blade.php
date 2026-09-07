```blade
@extends('layouts.blog')

@section('title', $post->title)

@section('description', \Illuminate\Support\Str::limit(strip_tags($post->content), 155))

@section('og_image', $post->image ? asset('storage/' . $post->image) : asset('images/default-cover.jpg'))

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gold-100">

        <a href="{{ route('posts.index') }}" class="text-gold-600 hover:underline text-sm">
            ← Back to articles
        </a>

        @if($post->image)
            <img
                src="{{ asset('storage/' . $post->image) }}"
                alt="{{ $post->title }}"
                class="w-full h-64 object-cover rounded-xl my-4"
            >
        @endif

        <span class="text-xs text-gold-600 font-semibold uppercase tracking-wide">
            {{ $post->category->name ?? 'No category' }}
        </span>

        <h1 class="font-serif text-4xl font-bold text-gray-800 mt-2">
            {{ $post->title }}

            @if($post->status === 'draft')
                <span class="ml-2 align-middle text-xs bg-gold-100 text-gold-700 px-3 py-1 rounded-full">
                    📝 Draft
                </span>
            @endif
        </h1>

        <div class="text-sm text-gray-500 mt-2 mb-6">
            By

            @if($post->user)
                <a
                    href="{{ route('users.show', $post->user->id) }}"
                    class="text-gold-600 hover:underline"
                >
                    {{ $post->user->name }}
                </a>
            @else
                Anonymous
            @endif

            — {{ $post->created_at->format('d/m/Y') }}
            — 👁️ {{ $post->views }} views
        </div>

        <div class="prose prose-lg max-w-none prose-headings:text-gray-800 prose-a:text-gold-600">
            {!! $post->content !!}
        </div>


        {{-- Tags --}}
        @if($post->tags->count())
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                    <a
                        href="{{ route('tags.show', $tag) }}"
                        class="bg-gold-50 text-gold-700 text-xs px-3 py-1 rounded-full hover:bg-gold-100"
                    >
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif


        {{-- Like button --}}
        <div class="mt-6 flex items-center gap-2">

            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                @csrf

                <button
                    type="submit"
                    aria-label="{{ $hasLiked ? 'Unlike this recipe' : 'Like this recipe' }}"
                    class="flex items-center gap-1 text-lg {{ $hasLiked ? 'text-red-500' : 'text-gray-400' }} hover:text-red-500 hover:scale-110 active:scale-90 transition-all duration-200"
                >
                    {{ $hasLiked ? '❤️' : '🤍' }}

                    <span class="text-sm text-gray-600">
                        {{ $likeCount }}
                    </span>
                </button>
            </form>

        </div>


        {{-- Actions: Edit / Delete (visible only to the author) --}}
        @if(auth()->id() === $post->user_id)
            <div class="flex gap-3 mt-8 pt-6 border-t">

                <a
                    href="{{ route('posts.edit', $post->id) }}"
                    class="bg-gold-400 text-white px-4 py-2 rounded-full hover:bg-gold-500 hover:scale-105 active:scale-95 transition-all duration-200"
                >
                    ✏️ Edit
                </a>

                <form
                    action="{{ route('posts.destroy', $post->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this post?')"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 hover:scale-105 active:scale-95 transition-all duration-200"
                    >
                        🗑️ Delete
                    </button>
                </form>

            </div>
        @endif

    </div>


    {{-- Comments Section --}}
    <div class="bg-white rounded-2xl shadow-sm p-8 mt-6 border border-gold-100">

        <h2 class="font-serif text-xl font-bold text-gray-800 mb-4">
            💬 Comments ({{ $post->comments->count() }})
        </h2>


        {{-- Add comment --}}
        @auth
            <form
                action="{{ route('comments.store', $post->id) }}"
                method="POST"
                class="mb-6"
            >
                @csrf

                <textarea
                    name="content"
                    rows="3"
                    placeholder="Write a comment..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400"
                >{{ old('content') }}</textarea>

                @error('content')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

                <button
                    type="submit"
                    class="mt-2 bg-gold-400 text-white px-4 py-2 rounded-full hover:bg-gold-500 transition"
                >
                    Post comment
                </button>
            </form>
        @else
            <p class="text-gray-500 mb-6">
                <a
                    href="{{ route('login') }}"
                    class="text-gold-600 hover:underline"
                >
                    Log in
                </a>
                to leave a comment.
            </p>
        @endauth


        {{-- Comments list --}}
        @forelse($post->comments as $comment)

            <div class="border-b py-3 flex justify-between items-start">

                <div>
                    <p class="font-semibold text-gray-700">
                        {{ $comment->user->name ?? 'Anonymous' }}
                    </p>

                    <p class="text-gray-600">
                        {{ $comment->content }}
                    </p>
                </div>


                {{-- Only the comment owner sees the delete button --}}
                @auth
                    @if(auth()->id() === $comment->user_id)

                        <form
                            action="{{ route('comments.destroy', $comment->id) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this comment?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="text-red-600 text-sm hover:underline"
                            >
                                Delete
                            </button>
                        </form>

                    @endif
                @endauth

            </div>

        @empty

            <p class="text-gray-500">
                No comments yet.
            </p>

        @endforelse

    </div>


    {{-- Related Posts --}}
    @if($relatedPosts->count())

        <div class="mt-6">

            <h2 class="font-serif text-xl font-bold text-gray-800 mb-4">
                📚 Related Articles
            </h2>

            <div class="grid md:grid-cols-3 gap-4">

                @foreach($relatedPosts as $related)

                    <a
                        href="{{ route('posts.show', $related->id) }}"
                        class="bg-white rounded-2xl shadow-sm p-4 hover:shadow-lg transition block border border-gold-100"
                    >

                        @if($related->image)
                            <img
                                src="{{ asset('storage/' . $related->image) }}"
                                alt="{{ $related->title }}"
                                class="w-full h-32 object-cover rounded-xl mb-3"
                            >
                        @endif

                        <h3 class="font-serif font-bold text-gray-800">
                            {{ $related->title }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ Str::limit(strip_tags($related->content), 80) }}
                        </p>

                    </a>

                @endforeach

            </div>

        </div>

    @endif

@endsection
