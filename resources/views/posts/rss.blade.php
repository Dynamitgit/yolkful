{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0">
    <channel>
        <title>Protein Mornings</title>
        <link>{{ url('/') }}</link>
        <description>Latest articles from Protein Mornings</description>
        <language>en</language>

        @foreach($posts as $post)
        <item>
            <title>{{ $post->title }}</title>
            <link>{{ route('posts.show', $post->id) }}</link>
            <guid>{{ route('posts.show', $post->id) }}</guid>
            <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
            <description>{{ strip_tags($post->content) }}</description>
        </item>
        @endforeach

    </channel>
</rss>