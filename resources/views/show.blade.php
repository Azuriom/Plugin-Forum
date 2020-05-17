@extends('layouts.app')

@section('title', $forum->name)

@section('content')
    <div class="container content">
        @include('forum::elements.nav')

        <h1>{{ $forum->name }}</h1>

        <div class="card mb-3">
            <div class="card-header">{{ trans('forum::messages.discussions.title') }}</div>
            <div class="list-group list-group-flush">
                @foreach($forum->discussions as $discussion)
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-2 col-md-1 text-center forum-big-icon">
                                <i class="fas fa-comment fa-fw"></i>
                            </div>

                            <div class="col-8 col-md-5">
                                <a href="{{ route('forum.discussions.show', $discussion) }}">{{ $discussion->title }}</a>
                                <br>
                                <small>{{ $discussion->author->name }}, {{ format_date($discussion->created_at) }}</small>
                            </div>

                            <div class="col-2">
                                @if($discussion->is_pinned || $discussion->is_locked)
                                    <div class="float-md-right">
                                        @if($discussion->is_pinned)
                                            <i class="fas fa-thumbtack fa-fw text-primary" title="{{ trans('forum::messages.discussions.pinned') }}" data-toggle="tooltip"></i>
                                        @endif

                                        @if($discussion->is_locked)
                                            <i class="fas fa-lock fa-fw text-warning" title="{{ trans('forum::messages.discussions.locked') }}" data-toggle="tooltip"></i>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-2 d-none d-md-block">
                                {{ trans_choice('forum::messages.discussions.posts-count', $discussion->posts_count) }}
                            </div>

                            <div class="col-md-2 d-none d-md-block">
                                @if(($discussionPost = $discussion->posts()->latest()->first()) !== null)
                                    {{ $discussionPost->author->name }},
                                    <small>{{ format_date($discussionPost->created_at) }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{ $forum->discussions->links() }}

        @can('create', \Azuriom\Plugin\Forum\Models\Discussion::class)
            <a href="{{ route('forum.forum.discussions.create', $forum->slug) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                {{ trans('messages.actions.create') }}
            </a>
        @endcan
    </div>
@endsection
