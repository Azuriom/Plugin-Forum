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
        <label for="categorySelect">{{ trans('forum::messages.fields.category') }}</label>

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
        <label for="iconInput">{{ trans('forum::messages.fields.icon') }}</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="{{ $forum->icon ?? 'fas fa-comments' }}"></i></span>
            </div>

            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="iconInput" name="icon" value="{{ old('icon', $forum->icon ?? '') }}" required placeholder="fas fa-comments" aria-labelledby="iconLabel">

            @error('icon')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <small id="iconLabel" class="form-text">@lang('forum::admin.forums.icons')</small>
    </div>
</div>

<div class="form-group">
    <label for="descriptionInput">{{ trans('messages.fields.description') }}</label>
    <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description" value="{{ old('description', $forum->description ?? '') }}" required>

    @error('description')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>
