@extends('layouts.app')

@section('title', trans('forum::messages.posts.title-edit'))

@section('content')
    <div class="container content">
        @include('forum::elements.nav')

        <h1>{{ trans('forum::messages.posts.title-edit') }}</h1>

        <form action="{{ route('forum.discussions.posts.update', [$post->discussion, $post]) }}" method="POST">
            @csrf
            @method('PUT')

            @include('forum::elements.markdown-editor', ['editor' => $post->content_format ?? null])

            <div class="form-group">
                <label for="content">{{ trans('messages.comments.your-comment') }}</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content', $post->content) }}</textarea>

                @error('content')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>
    </div>
@endsection
