{!! '<?xml version="1.0" encoding="utf-8"?>' !!}
<rss version="2.0"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
    <channel>
        <title>{{ $title }}</title>
        <link>{{ $forum !== null ? route('forum.show', $forum->slug) : route('forum.home') }}</link>
        @if($description)
            <description>{{ $description }}</description>
        @endif
        <language>{{ app()->getLocale() }}</language>
        <lastBuildDate>{{ $updatedAt->toRssString() }}</lastBuildDate>

        <atom:link href="{{ $feedUrl }}" rel="self" type="application/rss+xml"/>

        @foreach($discussions as $discussion)
            <item>
                <guid isPermaLink="true">{{ route('forum.discussions.show', $discussion) }}</guid>
                <title>{{ $discussion->title }}</title>
                <link>{{ route('forum.discussions.show', $discussion) }}</link>
                <pubDate>{{ $discussion->created_at->toRssString() }}</pubDate>

                <dc:creator>{{ $discussion->author->name }}</dc:creator>
                <category>{{ $discussion->forum->name }}</category>
                <slash:comments>{{ max(0, $discussion->posts_count - 1) }}</slash:comments>
                <content:encoded>{{ $discussion->firstPost?->parseContentRaw() }}</content:encoded>
            </item>
        @endforeach
    </channel>
</rss>
