@csrf

@include('forum::elements.markdown-editor')

<div class="form-group">
    <label for="titleInput">{{ trans('messages.fields.title') }}</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" value="{{ old('title', $discussion->title ?? '') }}" required>

    @error('title')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="content">{{ trans('messages.fields.content') }}</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content', $discussionContent ?? '') }}</textarea>

    @error('content')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

@can('forum.discussions')
    <div class="form-group custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="pinSwitch" name="is_pinned" @if($discussion->is_pinned ?? false) checked @endif>
        <label class="custom-control-label" for="pinSwitch">{{ trans('forum::messages.discussions.pin') }}</label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="lockSwitch" name="is_locked" @if($discussion->is_locked ?? false) checked @endif>
        <label class="custom-control-label" for="lockSwitch">{{ trans('forum::messages.discussions.lock') }}</label>
    </div>
@endcan
