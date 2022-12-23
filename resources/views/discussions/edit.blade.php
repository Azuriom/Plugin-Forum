@extends('forum::layouts.forum')

@section('title', trans('forum::messages.discussions.edit'))

@include('forum::elements.markdown-editor', [
    'imagesUploadUrl' => route('forum.posts.attachments.store', $firstPost),
])

@section('forum')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('forum.discussions.update', $discussion) }}" method="POST">
                @method('PUT')

                @include('forum::discussions._form')

                @can('forum.discussions')
                    <div class="mb-3">
                        <label class="form-label" for="forumSelect">{{ trans('forum::messages.fields.forum') }}</label>

                        <select class="form-select" id="forumSelect" name="forum_id">
                            @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @foreach($category->forums as $forum)
                                        <option value="{{ $forum->id }}" @selected($forum->id === (int) old('forum_id', $discussion->forum_id))>
                                            {{ $forum->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>

                        @error('forum_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                @endcan

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>

        </div>
    </div>
@endsection
