@extends('admin.layouts.admin')

@section('title', trans('forum::admin.settings.title'))

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('forum.admin.settings.save') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="delayInput">{{ trans('forum::admin.posts.delay') }}</label>

                    <div class="input-group @error('post_delay') has-validation @enderror">
                        <input type="number" min="0" class="form-control @error('post_delay') is-invalid @enderror" id="delayInput" name="post_delay" value="{{ old('post_delay', forum_post_delay()) }}" required>
                        <span class="input-group-text">{{ trans('forum::admin.posts.seconds') }}</span>

                        @error('post_delay')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="editorSelect">{{ trans('forum::messages.fields.editor') }}</label>
                    <select class="form-select @error('editor') is-invalid @enderror" id="editorSelect" name="editor">
                        <option value="bbcode" @selected($editor === 'bbcode')>BBCode</option>
                        <option value="markdown" @selected($editor === 'markdown')>Markdown</option>
                    </select>

                    @error('editor')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                </button>

            </form>

        </div>
    </div>
@endsection
