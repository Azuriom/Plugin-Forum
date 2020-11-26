@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="container content">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-md-3 text-center">
                        <img src="{{ $user->getAvatar(150) }}" class="rounded img-fluid" alt="{{ $user->name }}">
                    </div>

                    <div class="col-lx-10 col-md-9">
                        <h1 class="mb-1">{{ $user->name }}</h1>

                        <h2 class="h4">
                            <span class="badge" style="{{ $user->role->getBadgeStyle() }}; vertical-align: middle">{{ $user->role->name }}</span>
                        </h2>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <strong>{{ trans('forum::messages.profile.discussions') }}:</strong> {{ $user->discussions_count }}
                            </li>
                            <li>
                                <strong>{{ trans('forum::messages.profile.posts') }}:</strong> {{ $user->posts_count }}
                            </li>
                            <li>
                                <strong>{{ trans('forum::messages.profile.likes') }}:</strong> {{ $user->likes_count }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">
                    {{ trans('forum::messages.profile.posts') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">
                    {{ trans('forum::messages.profile.information') }}
                </a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                <div class="list-group list-group-flush">
                    @foreach($posts as $post)
                        <div class="list-group-item">
                            <h3 class="h5">
                                <a href="{{ route('forum.discussions.show', $post->discussion) }}">
                                    {{ $post->discussion->title }}
                                </a>
                            </h3>

                            <p>{{ Str::limit($post->content) }}</p>

                            <small class="text-muted d-block">
                                {{ format_date($post->created_at) }}
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="tab-pane fade p-3" id="info" role="tabpanel" aria-labelledby="info-tab">
                @if($user->user->about)
                    <h5>{{ trans('forum::messages.profile.about') }}</h5>

                    <div class="markdown-body">
                        {{ $user->user->parseAbout() }}
                    </div>

                    <hr>
                @endif

                <p>
                    @if($user->user->website)
                        {{ trans('forum::messages.profile.website') }}:
                        <a href="{{ $user->user->website }}" target="_blank" rel="noopener noreferrer">
                            {{ $user->user->website }}
                        </a>
                    @endif
                </p>

                @if($user->user->discord)
                    <p>Discord: <b>{{ $user->user->discord }}</b></p>
                @endif

                @if($user->user->twitter)
                    <p>
                        Twitter:
                        <a href="https://twitter.com/{{ $user->user->twitter }}" target="_blank" rel="noopener noreferrer">
                            {{ '@'.$user->user->twitter }}
                        </a>
                    </p>
                @endif

                @if($user->id === Auth::id())
                    <a href="{{ route('forum.profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> {{ trans('messages.actions.edit') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
