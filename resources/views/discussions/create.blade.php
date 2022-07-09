@extends('layouts.app')

@section('title', trans('forum::messages.discussions.create'))

@include('forum::elements.markdown-editor', [
    'imagesUploadUrl' => route('forum.posts.attachments.pending', $pendingId),
])

@section('content')
    @include('forum::elements.nav')

    <h1>{{ trans('forum::messages.discussions.create') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.forum.discussions.store', $forum->slug) }}" method="POST">
                <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                @include('forum::discussions._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
