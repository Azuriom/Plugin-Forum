@csrf

<div class="form-group">
    <label for="nameInput">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $forum->name ?? '') }}" required>

    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="slugInput">{{ trans('messages.fields.slug') }}</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">{{ route('forum.home') }}/</div>
        </div>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slugInput" name="slug" value="{{ old('slug', $forum->slug ?? '') }}" required>

        @error('slug')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="categorySelect">{{ trans('messages.fields.category') }}</label>

        <select class="custom-select" id="categorySelect" name="category_id">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(old('category_id', $forum->category_id ?? 0) === $category->id) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>

        @error('category_id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="iconInput">{{ trans('messages.fields.icon') }}</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="{{ $forum->icon ?? 'fas fa-comments' }} fa-fw"></i></span>
            </div>

            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="iconInput" name="icon" value="{{ old('icon', $forum->icon ?? '') }}" placeholder="fas fa-comments" aria-labelledby="iconLabel">

            @error('icon')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <small id="iconLabel" class="form-text">@lang('forum::admin.forums.icons')</small>
    </div>
</div>

<div class="form-group">
    <label for="descriptionInput">{{ trans('messages.fields.description') }}</label>
    <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description" value="{{ old('description', $forum->description ?? '') }}">

    @error('description')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="lockSwitch" name="is_locked" aria-describedby="lockLabel" @if($forum->is_locked ?? false) checked @endif>
    <label class="custom-control-label" for="lockSwitch">{{ trans('forum::admin.forums.lock') }}</label>

    <small id="lockLabel" class="form-text">{{ trans('forum::admin.forums.lock-info') }}</small>
</div>

<div class="form-group custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="restrictedSwitch" name="is_restricted" data-toggle="collapse" data-target="#rolesGroup" @if(isset($forum) && $forum->roles !== null) checked @endif>
    <label class="custom-control-label" for="restrictedSwitch">{{ trans('forum::admin.forums.restricted') }}</label>
</div>

<div id="rolesGroup" class="{{ (isset($forum) && $forum->roles !== null) ?  'show' : 'collapse' }}">
    <div class="card card-body mb-2 pb-0">
        @foreach($roles as $role)
            <div class="form-group custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="role{{ $role->id }}" name="roles[]" value="{{ $role->id }}" @if(isset($forum) && $forum->roles !== null && $forum->hasRole($role)) checked @endif">
                <label class="custom-control-label" for="role{{ $role->id }}">
                    <span class="badge" style="{{ $role->getBadgeStyle() }}">{{ $role->name }}</span>
                </label>
            </div>
        @endforeach
    </div>
</div>

@if(! $tags->isEmpty())
    <label>{{ trans('forum::admin.forums.default_tags') }}</label>

    <div class="card card-body mb-2 pb-0">
        @foreach($tags as $tag)
            <div class="form-group custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="tag{{ $tag->id }}" name="default_tags[]" value="{{ $tag->id }}" @if(isset($forum) && in_array($tag->id, $forum->default_tags ?? [], true)) checked @endif">
                <label class="custom-control-label" for="tag{{ $tag->id }}">
                    <span class="badge" style="{{ $tag->getBadgeStyle() }}">{{ $tag->name }}</span>
                </label>
            </div>
        @endforeach
    </div>
@endif
