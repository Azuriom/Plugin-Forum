@extends('forum::layouts.forum')

@section('title', trans('forum::messages.posts.edit'))

@include('forum::elements.markdown-editor', [
    'editor' => $post->content_format ?? null,
    'imagesUploadUrl' => route('forum.posts.attachments.store', $post),
])

@section('forum')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.discussions.posts.update', [$post->discussion, $post]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="content">{{ trans('messages.comments.content') }}</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content', $post->content) }}</textarea>

                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
