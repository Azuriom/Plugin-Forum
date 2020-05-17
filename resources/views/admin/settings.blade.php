@extends('admin.layouts.admin')

@section('title', trans('forum::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">

            <form action="{{ route('forum.admin.settings.save') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="delayInput">{{ trans('forum::admin.posts.delay') }}</label>

                    <div class="input-group">
                        <input type="number" min="0" class="form-control @error('post_delay') is-invalid @enderror" id="delayInput" name="post_delay" value="{{ old('post_delay', forum_post_delay()) }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">{{ trans('forum::admin.posts.seconds') }}</span>
                        </div>

                        @error('post_delay')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                </button>

            </form>

        </div>
    </div>
@endsection
