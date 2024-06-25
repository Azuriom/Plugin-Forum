@extends('admin.layouts.admin')

@section('title', trans('forum::admin.settings.title'))

@include('admin.elements.editor')

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('forum.admin.settings.save') }}" method="POST">
                @csrf

                <div class="row gx-3">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="delayInput">{{ trans('forum::admin.posts.delay') }}</label>

                        <div class="input-group @error('post_delay') has-validation @enderror">
                            <input type="number" min="0" class="form-control @error('post_delay') is-invalid @enderror" id="delayInput" name="post_delay" value="{{ old('post_delay', forum_post_delay()) }}" required>
                            <span class="input-group-text">{{ trans('forum::admin.posts.seconds') }}</span>

                            @error('post_delay')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="recentPosts">{{ trans('forum::admin.posts.recent') }}</label>
                        <input type="number" min="0" class="form-control @error('recent_posts') is-invalid @enderror" id="recentPosts" name="recent_posts" value="{{ old('recent_posts', $recentPosts) }}" required>

                        @error('recent_posts')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="editorSelect">{{ trans('forum::messages.fields.editor') }}</label>
                        <select class="form-select @error('editor') is-invalid @enderror" id="editorSelect" name="editor">
                            <option value="bbcode" @selected($editor === 'bbcode')>BBCode</option>
                            <option value="markdown" @selected($editor === 'markdown')>Markdown</option>
                        </select>

                        @error('editor')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="webhookInput">{{ trans('forum::admin.settings.webhook') }}</label>
                    <input type="text" class="form-control @error('webhook') is-invalid @enderror" id="webhookInput" name="webhook" placeholder="https://discord.com/api/webhooks/.../..." value="{{ old('webhook', $webhook) }}" aria-describedby="webhookInfo">

                    @error('webhook')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <div id="webhookInfo" class="form-text">{{ trans('forum::admin.settings.webhook_info') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="homeMessage">{{ trans('forum::admin.settings.home_message') }}</label>
                    <textarea class="form-control html-editor @error('home_message') is-invalid @enderror" id="homeMessage" name="home_message" rows="5">{{ old('home_message', $homeMessage) }}</textarea>

                    @error('home_message')
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
