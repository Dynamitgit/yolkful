<?php

namespace App\Http\Controllers;

use App\Models\Collection;

class CollectionController extends Controller
{
    public function show(Collection $collection)
    {
        $posts = $collection->posts()
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('collections.show', compact('collection', 'posts'));
    }
}