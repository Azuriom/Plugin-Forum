@csrf

<div class="mb-3">
    <label class="form-label" for="nameInput">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $forum->name ?? '') }}" required>

    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="slugInput">{{ trans('messages.fields.slug') }}</label>
    <div class="input-group @error('slug') has-validation @enderror">
        <div class="input-group-text">{{ route('forum.home') }}/</div>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slugInput" name="slug" value="{{ old('slug', $forum->slug ?? '') }}" required>

        @error('slug')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row g-3">
    <div class="mb-3 col-md-6">
        <label class="form-label" for="categorySelect">{{ trans('messages.fields.category') }}</label>

        <select class="form-select" id="categorySelect" name="category_id">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((int) old('category_id', $forum->category_id ?? 0) === $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label" for="iconInput">{{ trans('messages.fields.icon') }}</label>

        <div class="input-group @error('icon') has-validation @enderror">
            <span class="input-group-text">
                <i class="{{ $forum->icon ?? 'bi bi-chat' }}"></i>
            </span>

            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="iconInput" name="icon" value="{{ old('icon', $forum->icon ?? '') }}" placeholder="bi bi-chat" aria-labelledby="iconLabel">

            @error('icon')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <small id="iconLabel" class="form-text">@lang('messages.icons')</small>
    </div>
</div>

<div class="row g-3">
    <div class="mb-3 col-md-6">
        <label class="form-label" for="parentSelect">{{ trans('forum::admin.forums.parent') }}</label>

        <select class="form-select" id="parentSelect" name="parent_id">
            <option value="">{{ trans('messages.none') }}</option>
            @foreach($categories as $category)
                <optgroup label="{{ $category->name }}">
                    @foreach($category->forums->except($forum->id ?? null) as $sub)
                        <option value="{{ $sub->id }}" @selected((int) old('parent_id', $forum->parent_id ?? 0) === $sub->id)>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>

        @error('category_id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label" for="descriptionInput">{{ trans('messages.fields.description') }}</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description" value="{{ old('description', $forum->description ?? '') }}">

        @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="lockSwitch" name="is_locked" aria-describedby="lockLabel" @checked($forum->is_locked ?? false)>
    <label class="form-check-label" for="lockSwitch">{{ trans('forum::admin.forums.lock') }}</label>

    <small id="lockLabel" class="form-text">{{ trans('forum::admin.forums.lock_info') }}</small>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="privateSwitch" name="is_private" aria-describedby="privateLabel" @checked($forum->is_private ?? false)>
    <label class="form-check-label" for="privateSwitch">{{ trans('forum::admin.forums.private') }}</label>

    <small id="privateLabel" class="form-text">{{ trans('forum::admin.forums.private_info') }}</small>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="restrictedSwitch" name="is_restricted" data-bs-toggle="collapse" data-bs-target="#rolesGroup" @checked(isset($forum) && $forum->roles !== null)>
    <label class="form-check-label" for="restrictedSwitch">{{ trans('forum::admin.forums.restricted') }}</label>
</div>

<div id="rolesGroup" class="{{ (isset($forum) && $forum->roles !== null) ?  'show' : 'collapse' }}">
    <div class="card card-body mb-2 pb-0">
        @foreach($roles as $role)
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="role{{ $role->id }}" name="roles[]" value="{{ $role->id }}" @checked(isset($forum) && $forum->roles !== null && $forum->hasRole($role))>
                <label class="form-check-label" for="role{{ $role->id }}">
                    <span class="badge" style="{{ $role->getBadgeStyle() }}">{{ $role->name }}</span>
                </label>
            </div>
        @endforeach
    </div>
</div>

@if(! $tags->isEmpty())
    <label class="form-label">{{ trans('forum::admin.forums.default_tags') }}</label>

    <div class="card card-body mb-2 pb-0">
        @foreach($tags as $tag)
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="tag{{ $tag->id }}" name="default_tags[]" value="{{ $tag->id }}" @checked(isset($forum) && in_array($tag->id, $forum->default_tags ?? [], true))>
                <label class="form-check-label" for="tag{{ $tag->id }}">
                    <span class="badge" style="{{ $tag->getBadgeStyle() }}">{{ $tag->name }}</span>
                </label>
            </div>
        @endforeach
    </div>
@endif
