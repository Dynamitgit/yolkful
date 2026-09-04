@extends('layouts.blog')
@section('title', 'All Posts')
@section('content')
    <h1 class="font-serif text-4xl font-bold text-gray-800 mb-8">All Articles</h1>
    <div class="grid gap-6">
        @forelse($posts as $post)
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 p-6 border border-gold-100">
                @if($post->image)
                    <div class="overflow-hidden rounded-xl mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                @endif
                <span class="text-xs text-gold-600 font-semibold uppercase tracking-wide">{{ $post->category->name ?? 'No category' }}</span>
                <h2 class="font-serif text-2xl font-bold text-gray-800 mt-1">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:text-gold-600 transition-colors">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ Str::limit(strip_tags($post->content), 150) }}
                </p>

                @if($post->tags->count())
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('tags.show', $tag) }}" class="bg-gold-50 text-gold-700 text-xs font-medium px-2.5 py-1 rounded-full hover:bg-gold-100 hover:scale-105 transition-all duration-200">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                    <span>By {{ $post->user->name ?? 'Anonymous' }} — {{ $post->created_at->diffForHumans() }}</span>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-gold-600 font-medium hover:underline">
                        Read more →
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-10">No articles published yet.</p>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection