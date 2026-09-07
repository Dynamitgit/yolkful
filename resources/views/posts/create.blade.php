@extends('layouts.blog')

@section('title', 'New Post')

@section('content')

<div class="max-w-4xl mx-auto py-10 px-4">

    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">

        <h1 class="font-serif text-3xl font-bold text-gray-800 mb-6">
            📝 Create a new article
        </h1>

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            id="post-form"
            action="{{ route('posts.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            {{-- Title --}}
            <div class="mb-5">
                <label
                    for="title"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Title
                </label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    placeholder="Enter your article title"
                >
            </div>

            {{-- Image --}}
            <div class="mb-5">
                <label
                    for="image"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Image
                    <span class="font-normal text-gray-400">(optional)</span>
                </label>

                <input
                    id="image"
                    type="file"
                    name="image"
                    accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >
            </div>

            {{-- Category --}}
            <div class="mb-5">
                <label
                    for="category_id"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Category
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
                    <option value="">-- Choose a category --</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Collection --}}
            <div class="mb-5">
                <label
                    for="collection_id"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Collection
                    <span class="font-normal text-gray-400">(optional)</span>
                </label>

                <select
                    id="collection_id"
                    name="collection_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
                    <option value="">-- No collection --</option>

                    @foreach($collections as $collection)
                        <option
                            value="{{ $collection->id }}"
                            {{ old('collection_id') == $collection->id ? 'selected' : '' }}
                        >
                            {{ $collection->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Content --}}
            <div class="mb-5">
                <label
                    for="editor"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Content
                </label>

                <div
                    id="editor"
                    class="bg-white"
                    style="height: 300px;"
                >{!! old('content') !!}</div>

                <input
                    type="hidden"
                    name="content"
                    id="content-input"
                >
            </div>

            {{-- Tags --}}
            <div class="mb-5">

                <label class="block text-gray-700 font-semibold mb-3">
                    Tags
                </label>

                @if($tags->count())

                    <div class="flex flex-wrap gap-3">

                        @foreach($tags as $tag)

                            <label class="flex items-center gap-2 bg-yellow-50 border border-yellow-100 px-3 py-2 rounded-lg cursor-pointer hover:bg-yellow-100 transition">

                                <input
                                    type="checkbox"
                                    name="tags[]"
                                    value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                >

                                <span class="text-gray-700">
                                    {{ $tag->name }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                @else

                    <p class="text-gray-400 text-sm">
                        No tags available yet.
                    </p>

                @endif

            </div>

            {{-- Status --}}
            <div class="mb-6">

                <label
                    for="status"
                    class="block text-gray-700 font-semibold mb-2"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
                    <option
                        value="draft"
                        {{ old('status', 'published') === 'draft' ? 'selected' : '' }}
                    >
                        Draft
                    </option>

                    <option
                        value="published"
                        {{ old('status', 'published') === 'published' ? 'selected' : '' }}
                    >
                        Published
                    </option>
                </select>

            </div>

            {{-- Buttons --}}
            <div class="flex flex-wrap gap-3">

                <button
                    type="submit"
                    class="bg-yellow-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-yellow-600 transition"
                >
                    Publish
                </button>

                <a
                    href="{{ route('posts.index') }}"
                    class="bg-gray-100 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

{{-- Quill --}}
<link
    href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css"
    rel="stylesheet"
>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const editorElement = document.getElementById('editor');
        const form = document.getElementById('post-form');
        const contentInput = document.getElementById('content-input');

        if (!editorElement || !form || !contentInput) {
            return;
        }

        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        const oldContent = @json(old('content'));

        if (oldContent) {
            quill.root.innerHTML = oldContent;
        }

        form.addEventListener('submit', function () {
            contentInput.value = quill.root.innerHTML;
        });

    });
</script>

@endsection