@extends('layouts.blog')

@section('title', 'Yolkful | High-Protein Breakfast Recipes for Real Mornings')
@section('description', 'Simple, delicious, high-protein breakfast recipes for real mornings.')

@section('content')

  <section class="pm-hero">

    {{-- Full-bleed breakfast photograph --}}
    <div class="pm-hero-image" aria-hidden="true">
        <img
            src="{{ asset('images/yolkful-hero-breakfast.png') }}"
            alt=""
        >
    </div>

    {{-- Hero content --}}
    <div class="pm-hero-copy">

        <h1>
            Better Breakfast Recipes,
            <span class="pm-orange">Every Day.</span>
        </h1>

        <p class="pm-lead">
            Easy, delicious, and high-protein breakfast recipes made for busy mornings.
        </p>

        <div class="pm-actions">
            <a class="pm-button" href="#recipes">
                Explore Breakfast Recipes <span aria-hidden="true">→</span>
            </a>
        </div>

       <div class="pm-benefits">

    <div class="pm-benefit">
        <span class="pm-benefit-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M13 2 4 14h6l-1 8 9-12h-6z"/></svg>
        </span>

        <span>
            <strong>Quick &amp; Easy</strong>
            <small>Breakfasts ready in 10–30 minutes</small>
        </span>
    </div>

    <div class="pm-benefit">
        <span class="pm-benefit-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M12 3.5c-3 3.8-5 7-5 10a5 5 0 0 0 10 0c0-3-2-6.2-5-10z"/></svg>
        </span>

        <span>
            <strong>High Protein</strong>
            <small>Protein-packed breakfasts that satisfy</small>
        </span>
    </div>

    <div class="pm-benefit">
        <span class="pm-benefit-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.5 2.5 4.5-5"/></svg>
        </span>

        <span>
            <strong>Meal Prep</strong>
            <small>Breakfasts you can make ahead and enjoy all week</small>
        </span>
    </div>

</div>
    </div>

</section>

<section class="pm-section" id="recipes"><div class="pm-shell"><header class="pm-section-head pm-section-head-featured"><span class="pm-kicker-badge">Seven Ways to Wake Up</span><h2 class="pm-featured-title">The Full <span class="pm-title-highlight">Spread<svg class="pm-squiggle" viewBox="0 0 140 14" preserveAspectRatio="none" aria-hidden="true"><path d="M2 8c15-9 25 4 40-3s25 6 38-1 25 5 38-2 15 3 20-1" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round"/></svg></span></h2></header><div class="pm-categories">@foreach($categories as $category)<a class="pm-category" href="{{ route('posts.index', ['category' => $category->slug]) }}"><img src="{{ asset('images/categories/'.$category->slug.'.jpg') }}" alt="{{ $category->name }}"><div class="pm-category-text"><h3>{{ $category->name }}</h3>@if($category->posts_count > 0)<p>{{ $category->posts_count }} {{ Str::plural('recipe', $category->posts_count) }}</p>@else<p style="visibility:hidden">placeholder</p>@endif<span class="pm-explore">Explore →</span></div></a>@endforeach</div></div></section>
<section class="pm-section pm-latest-section">
    <div class="pm-shell">

        <header class="pm-section-head pm-latest-heading">
            <span class="pm-kicker-badge">What's New</span>
            <h2 class="pm-featured-title">Fresh Breakfast Ideas</h2>
        </header>

        @if($latestPosts->count())
            <div class="pm-latest-grid">
                @foreach($latestPosts as $post)
                    <a class="pm-latest-card" href="{{ route('posts.show', $post) }}">
                        <div class="pm-latest-photo">

    @if($post->image)
        <img
            src="{{ asset('storage/' . $post->image) }}"
            alt="{{ $post->title }}"
            loading="lazy"
        >
    @else
        <div class="pm-latest-placeholder">
            <span>Yolkful</span>
        </div>
    @endif

    <span class="pm-latest-favorite">
        ...
    </span>

</div>


{{-- هنا خاص Recipe Info يكون --}}
@if(
    $post->prep_time ||
    $post->cook_time ||
    $post->protein ||
    $post->servings
)
    <div class="pm-latest-recipe-info">

        @if($post->prep_time || $post->cook_time)
            <span>
                ⏱️
                {{ ($post->prep_time ?? 0) + ($post->cook_time ?? 0) }} min
            </span>
        @endif

        @if($post->protein)
            <span>
                💪
                {{ rtrim(rtrim(number_format($post->protein, 2, '.', ''), '0'), '.') }}g protein
            </span>
        @endif

        @if($post->servings)
            <span>
                🍽️
                {{ $post->servings }} servings
            </span>
        @endif

    </div>
@endif


</a>
                        
                @endforeach
            </div>

            <div class="pm-latest-cta">
                <a href="{{ route('posts.index') }}">
                    See All Recipes <span aria-hidden="true">→</span>
                </a>
            </div>
        @else
            <p class="pm-latest-empty">No recipes published yet.</p>
        @endif

    </div>
</section>   
<section class="pm-section pm-section-soft">
    <div class="pm-shell pm-split">

        <aside class="pm-why">
            <p class="pm-kicker">Why protein in the morning?</p>

            <h2>Start Your Day Strong</h2>

            <p>
                A high-protein breakfast helps you stay full longer, supports muscle growth,
                boosts energy, and keeps you focused throughout the day.
            </p>

            <div class="pm-why-list">
                <span><b>⌁</b>Build<br>Muscle</span>
                <span><b>◷</b>Stay Full<br>Longer</span>
                <span><b>ϟ</b>Boost<br>Energy</span>
                <span><b>✓</b>Support<br>Your Goals</span>
            </div>

            <a class="pm-button" href="{{ route('posts.index') }}">
                Learn more about protein
            </a>
        </aside>

        <div class="pm-popular">

            <header class="pm-popular-heading">
                <h2>Popular This Week</h2>
                <a href="{{ route('posts.index') }}">View all recipes →</a>
            </header>

            <div class="pm-recipes">

                @forelse($popularPosts as $post)

                    <a class="pm-recipe" href="{{ route('posts.show', $post) }}">

                        <div class="pm-recipe-photo">

                            @if($post->image)
                                <img
                                    src="{{ asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                >
                            @else
                                <div class="pm-recipe-placeholder" aria-hidden="true">
                                    <span>Yolkful</span>
                                </div>
                            @endif

                            <span class="pm-time">
                                {{ $loop->iteration * 10 + 5 }} MIN
                            </span>

                        </div>

                        <div class="pm-recipe-body">
                            <h3>{{ $post->title }}</h3>

                            <p>
                                {{ $post->category->name ?? 'High protein' }} • Easy
                            </p>

                            <div class="pm-stars">
                                ★★★★★
                                <small>({{ $post->views }})</small>
                            </div>
                        </div>

                    </a>

                @empty

                    <p style="color:#5f675e; padding: 20px 0;">
                        No popular recipes yet — check back soon!
                    </p>

                @endforelse

            </div>
        </div>

    </div>
</section>

   <section class="pm-section"><div class="pm-shell"><div class="pm-newsletter"><div class="pm-newsletter-icon">✉</div><div><h2>Get New Recipes in Your Inbox</h2><p>Join our community and get easy, high-protein breakfast recipes sent to you every week!</p></div><form class="pm-subscribe" onsubmit="event.preventDefault()"><input type="email" aria-label="Email address" placeholder="Your email address"><button class="pm-button" type="submit">Subscribe</button></form></div></div></section>
@endsection