<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('tags.show', compact('tag', 'posts'));
    }
}