<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;

class LandingPageController extends Controller
{
    public function show(LandingPage $landingPage)
    {
        $posts = collect();

        if ($landingPage->tag) {
            $posts = $landingPage->tag->posts()
                ->where('status', 'published')
                ->latest()
                ->paginate(10);
        }

        return view('landing-pages.show', compact('landingPage', 'posts'));
    }
}