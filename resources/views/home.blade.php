@extends('layouts.app')

@section('title', trans('forum::messages.title'))

@section('content')
    <div class="container content">
        @include('forum::elements.nav')

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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
