@extends('layouts.blog')

@section('title', 'New Post')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gold-100">
        <h1 class="font-serif text-3xl font-bold text-gray-800 mb-6">📝 Create a new article</h1>

        {{-- Erreurs de validation --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400">
            </div>

            {{-- Image --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Image (optional)</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Category</label>
                <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400">
                    <option value="">-- Choose a category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Collection --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Collection (optional)</label>
                <select name="collection_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400">
                    <option value="">-- No collection --</option>
                    @foreach($collections as $collection)
                        <option value="{{ $collection->id }}" {{ old('collection_id') == $collection->id ? 'selected' : '' }}>
                            {{ $collection->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Contenu --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Content</label>

                {{-- Quill toolbar + editor box --}}
                <div id="editor" style="height: 250px; background: white;">{!! old('content') !!}</div>

                {{-- Hidden input that actually gets sent to the server --}}
                <input type="hidden" name="content" id="content-input">
            </div>

            {{-- Tags --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tags</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-2 bg-gold-50 px-3 py-2 rounded-lg cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                   {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Statut --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-gold-400 text-white px-6 py-2 rounded-full hover:bg-gold-500 transition">
                    Publish
                </button>
                <a href="{{ route('posts.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
    {{-- Quill Editor --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    const form = document.querySelector('#post-form');
    form.addEventListener('submit', function () {
        document.querySelector('#content-input').value = quill.root.innerHTML;
    });
</script>
@endsection