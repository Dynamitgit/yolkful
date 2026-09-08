@extends('layouts.blog')

@section('title', 'Edit: ' . $post->title)

@section('content')

    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gold-100">

        <h1 class="font-serif text-3xl font-bold text-gray-800 mb-6">
            ✏️ Edit article
        </h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            id="post-form"
            action="{{ route('posts.update', $post->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400"
                >
            </div>

            {{-- Image --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Image
                </label>

                @if($post->image)
                    <img
                        src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        class="w-32 h-32 object-cover rounded-lg mb-2"
                    >

                    <p class="text-sm text-gray-500 mb-2">
                        Current image (leave empty to keep it)
                    </p>
                @endif

                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Category
                </label>

                <select
                    name="category_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400"
                >
                    <option value="">
                        -- Choose a category --
                    </option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Collection --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Collection (optional)
                </label>

                <select
                    name="collection_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400"
                >
                    <option value="">
                        -- No collection --
                    </option>

                    @foreach($collections as $collection)
                        <option
                            value="{{ $collection->id }}"
                            {{ old('collection_id', $post->collection_id) == $collection->id ? 'selected' : '' }}
                        >
                            {{ $collection->name }}
                        </option>
                    @endforeach
                </select>
            </div>
                        {{-- Recipe Information --}}
            <div class="mb-6 p-5 rounded-xl border border-gold-100 bg-gold-50/30">

                <h2 class="font-serif text-xl font-bold text-gray-800 mb-4">
                    🍳 Recipe Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Prep Time --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Prep Time (minutes)
                        </label>

                        <input
                            type="number"
                            name="prep_time"
                            min="0"
                            value="{{ old('prep_time', $post->prep_time) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        >
                    </div>

                    {{-- Cook Time --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Cook Time (minutes)
                        </label>

                        <input
                            type="number"
                            name="cook_time"
                            min="0"
                            value="{{ old('cook_time', $post->cook_time) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        >
                    </div>

                    {{-- Servings --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Servings
                        </label>

                        <input
                            type="number"
                            name="servings"
                            min="1"
                            value="{{ old('servings', $post->servings) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        >
                    </div>

                    {{-- Protein --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Protein (g)
                        </label>

                        <input
                            type="number"
                            name="protein"
                            min="0"
                            step="0.01"
                            value="{{ old('protein', $post->protein) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        >
                    </div>

                    {{-- Calories --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Calories (kcal)
                        </label>

                        <input
                            type="number"
                            name="calories"
                            min="0"
                            value="{{ old('calories', $post->calories) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"
                        >
                    </div>

                </div>


                {{-- Ingredients --}}
                <div class="mt-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Ingredients
                    </label>

                    <textarea
                        name="ingredients_text"
                        rows="6"
                        placeholder="One ingredient per line"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >{{ old('ingredients_text', is_array($post->ingredients) ? implode("\n", $post->ingredients) : '') }}</textarea>
                </div>


                {{-- Instructions --}}
                <div class="mt-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Instructions
                    </label>

                    <textarea
                        name="instructions_text"
                        rows="6"
                        placeholder="One step per line"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2"
                    >{{ old('instructions_text', is_array($post->instructions) ? implode("\n", $post->instructions) : '') }}</textarea>
                </div>

            </div>

            {{-- Content --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Content
                </label>

                <div
                    id="editor"
                    style="height: 250px; background: white;"
                ></div>

                <input
                    type="hidden"
                    name="content"
                    id="content-input"
                >
            </div>

            {{-- Tags --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Tags
                </label>

                <div class="flex flex-wrap gap-3">

                    @php
                        $selectedTags = old(
                            'tags',
                            $post->tags->pluck('id')->toArray()
                        );
                    @endphp

                    @foreach($tags as $tag)
                        <label class="flex items-center gap-2 bg-gold-50 px-3 py-2 rounded-lg cursor-pointer">

                            <input
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                            >

                            {{ $tag->name }}

                        </label>
                    @endforeach

                </div>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400"
                >
                    <option
                        value="draft"
                        {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}
                    >
                        Draft
                    </option>

                    <option
                        value="published"
                        {{ old('status', $post->status) == 'published' ? 'selected' : '' }}
                    >
                        Published
                    </option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 mt-6">

                <button
                    type="submit"
                    class="bg-gold-400 text-white px-6 py-2 rounded-full hover:bg-gold-500 transition"
                >
                    Save changes
                </button>

                <a
                    href="{{ route('posts.index') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300 transition"
                >
                    Cancel
                </a>

            </div>

        </form>
    </div>

    {{-- Quill Editor --}}
    <link
        href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css"
        rel="stylesheet"
    >

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            const existingContent = @json(
                old('content', $post->content)
            );

            quill.root.innerHTML = existingContent;

            const form = document.querySelector('#post-form');
            const contentInput = document.querySelector('#content-input');

            form.addEventListener('submit', function () {
                contentInput.value = quill.root.innerHTML;
            });

        });
    </script>

@endsection