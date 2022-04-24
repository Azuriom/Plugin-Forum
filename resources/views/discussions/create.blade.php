@extends('layouts.app')

@section('title', trans('forum::messages.discussions.create'))

@section('content')
    @include('forum::elements.nav')

    <h1>{{ trans('forum::messages.discussions.create') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.forum.discussions.store', $forum->slug) }}" method="POST">
                @include('forum::discussions._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
