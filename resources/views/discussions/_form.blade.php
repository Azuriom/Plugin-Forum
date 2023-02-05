@csrf

<div class="mb-3">
    <label class="form-label" for="titleInput">{{ trans('messages.fields.title') }}</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" value="{{ old('title', $discussion->title ?? '') }}" required>

    @error('title')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="content">{{ trans('messages.fields.content') }}</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content', $discussionContent ?? '') }}</textarea>

    @error('content')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

@can('forum.discussions')
    <label class="form-label">{{ trans('forum::messages.fields.tags') }}</label>

    <div class="row mb-3">
        @foreach($tags as $tag)
            <div class="col-auto">
                <div class="mb-1 form-check">
                    <input type="checkbox" class="form-check-input" id="tag{{ $tag->id }}" name="tags[{{ $tag->id }}]" @checked(isset($discussion) && $discussion->tags->contains($tag->id))>
                    <label class="form-check-label" for="tag{{ $tag->id }}">
                        <span class="badge" style="{{ $tag->getBadgeStyle() }}">{{ $tag->name }}</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-3 form-check form-switch">
        <input type="checkbox" class="form-check-input" id="pinSwitch" name="is_pinned" @checked($discussion->is_pinned ?? false)>
        <label class="form-check-label" for="pinSwitch">{{ trans('forum::messages.discussions.pin') }}</label>
    </div>

    <div class="mb-3 form-check form-switch">
        <input type="checkbox" class="form-check-input" id="lockSwitch" name="is_locked" @checked($discussion->is_locked ?? false)>
        <label class="form-check-label" for="lockSwitch">{{ trans('forum::messages.discussions.lock') }}</label>
    </div>
@endcan
