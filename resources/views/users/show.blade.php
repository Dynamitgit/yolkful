@extends('layouts.blog')

@section('title', $user->name)

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-6 border border-gold-100">
        <h1 class="font-serif text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
        <p class="text-gray-500 mt-1">{{ $posts->total() }} published article(s)</p>
    </div>

    <div class="grid gap-6">
        @forelse($posts as $post)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gold-100">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-xl mb-4">
                @endif
                <span class="text-xs text-gold-600 font-semibold uppercase tracking-wide">{{ $post->category->name ?? 'Sans catégorie' }}</span>
                <h2 class="font-serif text-2xl font-bold text-gray-800 mt-1">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:text-gold-600">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ Str::limit(strip_tags($post->content), 150) }}
                </p>
                <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                    <span>{{ $post->created_at->diffForHumans() }}</span>
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