@extends('layouts.blog')
@section('title', $landingPage->title)
@section('description', $landingPage->meta_description)
@section('content')

    {{-- =====================================================
         LANDING PAGE HERO
    ====================================================== --}}

    <section class="pm-lp-hero">
        <div class="pm-shell pm-lp-hero-inner">

            <a href="{{ route('posts.index') }}" class="pm-lp-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                All recipes
            </a>

            <p class="pm-lp-kicker"><b></b>{{ $landingPage->tag->name ?? 'Recipe collection' }}</p>

            <h1>{{ $landingPage->title }}</h1>

            @if($landingPage->meta_description)
                <p class="pm-lp-lead">{{ $landingPage->meta_description }}</p>
            @endif

            <div class="pm-lp-meta">
                <span class="pm-lp-pill">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 9.5h14l-1.2 7.1a2 2 0 0 1-2 1.7H8.2a2 2 0 0 1-2-1.7z"/><path d="M8 9.5c.2-2 1.7-3.2 4-3.2s3.8 1.2 4 3.2"/></svg>
                    {{ $posts->total() }} {{ Str::plural('recipe', $posts->total()) }}
                </span>
                <span class="pm-lp-pill">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
                    Updated regularly
                </span>
            </div>

        </div>
    </section>

    @if($landingPage->intro_content)
        <div class="pm-shell" style="max-width:700px; padding-top:36px;">
            <div class="prose max-w-none text-gray-600">
                {!! $landingPage->intro_content !!}
            </div>
        </div>
    @endif

    <div class="pm-shell grid gap-6" style="padding-top:24px; padding-bottom:60px;">
        @forelse($posts as $post)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition p-6 border border-gold-100">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-xl mb-4">
                @endif
                <span class="text-xs text-gold-600 font-semibold uppercase tracking-wide">{{ $post->category->name ?? 'No category' }}</span>
                <h2 class="font-serif text-2xl font-bold text-gray-800 mt-1">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:text-gold-600">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-gray-600 mt-2">
                    {{ Str::limit(strip_tags($post->content), 150) }}
                </p>
                <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                    <span>By {{ $post->user->name ?? 'Anonymous' }} — {{ $post->created_at->diffForHumans() }}</span>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-gold-600 font-medium hover:underline">
                        Read more →
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-10">No articles here yet — check back soon!</p>
        @endforelse
    </div>

    @if($posts->count())
        <div class="pm-shell" style="padding-bottom:60px;">
            {{ $posts->links() }}
        </div>
    @endif
@endsection