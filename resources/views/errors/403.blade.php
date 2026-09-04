@extends('layouts.blog')

@section('title', 'Access Denied')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-12 text-center border border-gold-100">
        <div class="text-6xl mb-4">🚫</div>
        <h1 class="font-serif text-4xl font-bold text-gray-800 mb-2">403</h1>
        <p class="text-xl text-gray-600 mb-6">Access Denied</p>
        <p class="text-gray-500 mb-8">You don't have permission to access this page or perform this action.</p>
        <a href="{{ route('posts.index') }}" class="inline-block bg-gold-400 text-white px-6 py-3 rounded-full hover:bg-gold-500 transition">
            ← Back to homepage
        </a>
    </div>
@endsection