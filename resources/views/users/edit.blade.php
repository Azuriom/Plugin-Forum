@extends('layouts.app')

@section('title', trans('forum::messages.profile.edit'))

@section('content')
    <div class="container content">
        @include('forum::elements.nav')

        <h1>{{ trans('forum::messages.discussions.edit') }}</h1>

        <form action="{{ route('forum.profile.update', $user) }}" method="POST">
            @csrf

            @include('forum::elements.markdown-editor', ['editor' => 'markdown'])

            <div class="row g-3">
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="locationInput">{{ trans('forum::messages.profile.location') }}</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="locationInput" name="location" value="{{ old('location', $user->location ?? '') }}">

                    @error('location')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="websiteInput">{{ trans('forum::messages.profile.website') }}</label>
                    <input type="url" class="form-control @error('website') is-invalid @enderror" id="websiteInput" name="website" value="{{ old('website', $user->website ?? '') }}">

                    @error('website')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="about">{{ trans('forum::messages.profile.about') }}</label>
                <textarea class="form-control @error('about') is-invalid @enderror" id="about" name="about" rows="4">{{ old('about', $user->about ?? '') }}</textarea>

                @error('about')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="signature">{{ trans('forum::messages.profile.signature') }}</label>
                <textarea class="form-control @error('signature') is-invalid @enderror" id="signature" name="signature" rows="4">{{ old('signature', $user->signature ?? '') }}</textarea>

                @error('signature')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row g-3">
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="twitterInput">Twitter</label>
                    <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitterInput" name="twitter" value="{{ old('twitter', $user->twitter ?? '') }}">

                    @error('twitter')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="discordInput">Discord</label>
                    <input type="text" class="form-control @error('discord') is-invalid @enderror" id="discordInput" name="discord" value="{{ old('discord', $user->discord ?? '') }}" placeholder="User#0000">

                    @error('discord')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>
    </div>
@endsection
