@include('admin.elements.color-picker')

@csrf

<div class="row gx-3">
    <div class="mb-3 col-md-6">
        <label class="form-label" for="nameInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $tag->name ?? '') }}" required>

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label" for="colorInput">{{ trans('messages.fields.color') }}</label>
        <input type="color" class="mb-3 form-control form-control-color color-picker @error('color') is-invalid @enderror" id="colorInput" name="color" value="{{ old('color', $tag->color ?? '#2196f3') }}" required>

        @error('color')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 mt-0 form-check form-switch">
        <input type="checkbox" class="form-check-input" id="restrictedSwitch" name="is_restricted" data-bs-toggle="collapse" data-bs-target="#rolesGroup" @checked(isset($tag) && $tag->roles !== null)>
        <label class="form-check-label" for="restrictedSwitch">{{ trans('forum::admin.tags.restricted') }}</label>
    </div>

    <div id="rolesGroup" class="{{ (isset($tag) && $tag->roles !== null) ?  'show' : 'collapse' }}">
        <div class="card card-body mb-2 pb-0">
            @foreach($roles as $role)
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="role{{ $role->id }}" name="roles[]" value="{{ $role->id }}" @checked(isset($tag) && $tag->hasRole($role))>
                    <label class="form-check-label" for="role{{ $role->id }}">
                        <span class="badge" style="{{ $role->getBadgeStyle() }}">{{ $role->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
