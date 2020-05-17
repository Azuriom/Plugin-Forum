@extends('admin.layouts.admin')

@section('title', trans('forum::admin.forums.title-edit', ['forum' => $forum->name]))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('forum.admin.forums.update', $forum) }}" method="POST">
                @method('PUT')

                @include('forum::admin.forums._form')

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ trans('messages.actions.save') }}</button>
                <a href="{{ route('forum.admin.forums.destroy', $forum) }}" class="btn btn-danger" data-confirm="delete"><i class="fas fa-trash"></i> {{ trans('messages.actions.delete') }}</a>
            </form>
        </div>
    </div>
@endsection
