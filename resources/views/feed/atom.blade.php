{!! '<?xml version="1.0" encoding="utf-8"?>' !!}
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>{{ $forum !== null ? route('forum.show', $forum->slug) : route('forum.home') }}</id>
    <title>{{ $title }}</title>
    <updated>{{ $updatedAt->toAtomString() }}</updated>
    <link href="{{ $forum !== null ? route('forum.show', $forum->slug) : route('forum.home') }}"/>
    <link href="{{ $feedUrl }}" rel="self" type="application/atom+xml"/>

    @if($description)
        <subtitle>{{ $description }}</subtitle>
    @endif

    @foreach($discussions as $discussion)
        <entry>
            <id>{{ route('forum.discussions.show', $discussion) }}</id>
            <title>{{ $discussion->title }}</title>
            <link href="{{ route('forum.discussions.show', $discussion) }}"/>
            <author>
                <name>{{ $discussion->author->name }}</name>
            </author>

            <published>{{ $discussion->created_at->toAtomString() }}</published>
            <updated>{{ $discussion->updated_at->toAtomString() }}</updated>

            <content type="html">{{ $discussion->firstPost?->parseContentRaw() }}</content>

            <category term="{{ $discussion->forum->name }}"/>
        </entry>
    @endforeach
</feed>
