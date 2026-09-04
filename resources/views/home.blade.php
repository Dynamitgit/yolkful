@extends('layouts.blog')

@section('title', 'Yolkful | High-Protein Breakfast Recipes for Real Mornings')
@section('description', 'Simple, delicious, high-protein breakfast recipes for real mornings.')

@section('content')
    @php
        $categories = [
            ['Protein Pancakes', 'Fluffy, delicious & protein-packed.', 'https://images.unsplash.com/photo-1528207776546-365bb710ee93?auto=format&fit=crop&w=500&q=85'],
            ['Protein Oatmeal', 'Warm, cosy & packed with protein.', 'https://images.unsplash.com/photo-1517673400267-0251440c45dc?auto=format&fit=crop&w=500&q=85'],
            ['Protein Smoothies', 'Quick, fresh & nourishing.', 'https://images.unsplash.com/photo-1553530666-ba11a90a0868?auto=format&fit=crop&w=500&q=85'],
            ['Protein Bowls', 'Balanced bowls to power your morning.', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=500&q=85'],
            ['Protein Muffins', 'Perfect for busy mornings.', 'https://images.unsplash.com/photo-1607958996333-41aef7caefaa?auto=format&fit=crop&w=500&q=85'],
            ['Egg Breakfasts', 'Simple, classic & high in protein.', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=500&q=85'],
        ];
    @endphp

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
            <strong>Healthy &amp; Balanced</strong>
            <small>Wholesome ingredients, satisfying flavors</small>
        </span>
    </div>

</div>
    </div>

</section>

    <section class="pm-section" id="recipes"><div class="pm-shell"><header class="pm-section-head"><p>Find your favourite</p><h2>Browse by Category</h2></header><div class="pm-categories">@foreach($categories as [$name, $description, $image])<a class="pm-category" href="{{ route('posts.index') }}"><img src="{{ $image }}" alt="{{ $name }}"><div class="pm-category-text"><h3>{{ $name }}</h3><p>{{ $description }}</p><span class="pm-explore">Explore →</span></div></a>@endforeach</div></div></section>

    <section class="pm-section pm-section-soft"><div class="pm-shell pm-split"><aside class="pm-why"><p class="pm-kicker">Why protein in the morning?</p><h2>Start Your Day Strong</h2><p>A high-protein breakfast helps you stay full longer, supports muscle growth, boosts energy, and keeps you focused throughout the day.</p><div class="pm-why-list"><span><b>⌁</b>Build<br>Muscle</span><span><b>◷</b>Stay Full<br>Longer</span><span><b>ϟ</b>Boost<br>Energy</span><span><b>✓</b>Support<br>Your Goals</span></div><a class="pm-button" href="{{ route('posts.index') }}">Learn more about protein</a></aside><div class="pm-popular"><header class="pm-popular-heading"><h2>Popular This Week</h2><a href="{{ route('posts.index') }}">View all recipes →</a></header><div class="pm-recipes">@forelse($popularPosts as $post)<a class="pm-recipe" href="{{ route('posts.show', $post) }}"><div class="pm-recipe-photo">@if($post->image)<img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">@else<img src="https://images.unsplash.com/photo-1528207776546-365bb710ee93?auto=format&fit=crop&w=600&q=85" alt="Protein breakfast">@endif<span class="pm-time">{{ $loop->iteration * 10 + 5 }} MIN</span></div><div class="pm-recipe-body"><h3>{{ $post->title }}</h3><p>{{ $post->category->name ?? 'High protein' }} • Easy</p><div class="pm-stars">★★★★★ <small>({{ $post->views }})</small></div></div></a>@empty @foreach(array_slice($categories, 0, 3) as [$name, $description, $image])<a class="pm-recipe" href="{{ route('posts.index') }}"><div class="pm-recipe-photo"><img src="{{ $image }}" alt="{{ $name }}"><span class="pm-time">15 MIN</span></div><div class="pm-recipe-body"><h3>{{ $name }}</h3><p>30g protein • Easy</p><div class="pm-stars">★★★★★ <small>(128)</small></div></div></a>@endforeach @endforelse</div></div></div></section>

    <section class="pm-section"><div class="pm-shell"><div class="pm-newsletter"><div class="pm-newsletter-icon">✉</div><div><h2>Get New Recipes in Your Inbox</h2><p>Join our community and get easy, high-protein breakfast recipes sent to you every week!</p></div><form class="pm-subscribe" onsubmit="event.preventDefault()"><input type="email" aria-label="Email address" placeholder="Your email address"><button class="pm-button" type="submit">Subscribe</button></form></div></div></section>
@endsection
