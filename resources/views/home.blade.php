@extends('layouts.app')

@section('title', trans('forum::messages.title'))

@section('content')
    <div class="container content">
        @include('forum::elements.nav')

        <div class="row">
            <div class="col-md-9">
                @foreach($categories as $category)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>{{ $category->name }}</h5>
                            <small>{{ $category->description }}</small>
                        </div>

                        <div class="list-group list-group-flush">
                            @foreach($category->forums as $forum)
                                <div class="list-group-item">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-2 col-2 forum-big-icon text-center">
                                            <i class="fas fa-folder fa-fw"></i>
                                        </div>

                                        <div class="col-xl-8 col-md-7 col-10">
                                            <a href="{{ route('forum.show', $forum->slug) }}">{{ $forum->name }}</a>
                                            <br>
                                            {{ $forum->description }}
                                        </div>

                                        <div class="col-xl-3 col-md-3 d-none d-md-block">
                                            {{ trans_choice('forum::messages.forums.discussions-count', $forum->discussions_count) }}
                                            <br>
                                            {{ trans_choice('forum::messages.discussions.posts-count', $forum->posts_count) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-chart-bar"></i> {{ trans('forum::messages.stats.title') }}
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li>{{ trans_choice('forum::messages.stats.discussions', $discussionsCount) }}</li>
                            <li>{{ trans_choice('forum::messages.stats.posts', $postsCount) }}</li>
                            <li>{{ trans_choice('forum::messages.stats.users', $usersCount) }}</li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-users"></i> {{ trans('forum::messages.online.title') }}
                    </div>
                    <div class="card-body">
                        @empty($onlineUsers)
                            {{ trans('forum::messages.online.none') }}
                        @else
                            {{ implode(', ', $onlineUsers) }}
                        @endempty
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
