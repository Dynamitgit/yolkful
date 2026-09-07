<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ url('/') }}</loc>
    </url>

    <url>
        <loc>{{ url('/about') }}</loc>
    </url>

    @foreach ($posts as $post)
        <url>
            <loc>{{ route('posts.show', $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
        </url>
    @endforeach

    @foreach ($tags as $tag)
        <url>
            <loc>{{ route('tags.show', $tag->slug) }}</loc>
        </url>
    @endforeach

    @foreach ($collections as $collection)
        <url>
            <loc>{{ route('collections.show', $collection->slug) }}</loc>
        </url>
    @endforeach

    @foreach ($landingPages as $landingPage)
        <url>
            <loc>{{ route('landing-pages.show', $landingPage->slug) }}</loc>
        </url>
    @endforeach

</urlset>