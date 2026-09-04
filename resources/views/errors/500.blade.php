@extends('layouts.blog')

@section('title', 'Server Error')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-12 text-center border border-gold-100">
        <div class="text-6xl mb-4">⚠️</div>
        <h1 class="font-serif text-4xl font-bold text-gray-800 mb-2">500</h1>
        <p class="text-xl text-gray-600 mb-6">Something went wrong</p>
        <p class="text-gray-500 mb-8">Something went wrong on our end. Please try again later.</p>
        <a href="{{ route('posts.index') }}" class="inline-block bg-gold-400 text-white px-6 py-3 rounded-full hover:bg-gold-500 transition">
            ← Back to homepage
        </a>
    </div>
@endsection