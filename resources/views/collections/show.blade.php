@extends('layouts.blog')
@section('title', 'Collection: ' . $collection->name)
@section('content')
    <a href="{{ route('posts.index') }}" class="text-gold-600 hover:underline text-sm">← All articles</a>
    <h1 class="font-serif text-3xl font-bold text-gray-800 mt-2 mb-6">
        {{ $collection->name }}
    </h1>
    <div class="grid gap-6">
        @forelse($posts as $post)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gold-100">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-xl mb-4">
                @endif
                <span class="text-xs text-gold-600 font-semibold uppercase tracking-wide">{{ $post->category->name ?? 'No category' }}</span>
                <h2 class="font-serif text-2xl font-bold text-gray-800 mt-1">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-gold-600">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ Str::limit(strip_tags($post->content), 150) }}
                </p>
                @if($post->tags->count())
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach($post->tags as $t)
                            <span class="bg-gold-50 text-gold-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                #{{ $t->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
                <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                    <span>By {{ $post->user->name ?? 'Anonymous' }} — {{ $post->created_at->diffForHumans() }}</span>
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-gold-600 font-medium hover:underline">
                        Read more →
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-10">No articles in this collection yet.</p>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection